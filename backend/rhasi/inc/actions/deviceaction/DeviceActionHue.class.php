<?php
class DeviceActionHue extends Action {
  private $_sName = null;
  private $_sStatus = null;
  private $_iTime = 400;
  private $_iHue = null;
  private $_iBrightness = null;
  private $_iSaturation = null;
  
  
  public function __construct() {
    
  }
  
  public function run($bTest = false) {
    $sId = null;
    //Find device id
    $oMysqli = getMysqli();
    if ($stmt = $oMysqli->prepare("SELECT id FROM hue_lights WHERE name=?")) {
      $stmt->bind_param("s", $this->_sName);
      $stmt->execute();
      $stmt->bind_result($sId);
      $stmt->fetch();
      $stmt->close();
      
      //Prepare request
      $sUrl = $sUrl = "http://" . CONFIG_HUE_HOST . "/api/" . CONFIG_HUE_USER . "/lights/" . $sId . "/state";  
      
      if ($this->_sStatus != null) {
        $aObject["on"] = ($this->_sStatus == "on" ? true : false);
      }
      if ($this->_iTime != 400) {
       $aObject["transitiontime"] = round($this->_iTime / 100);
      }
      if ($this->_iHue != null) {
       $aObject["hue"] = $this->_iHue;
      }
      if ($this->_iSaturation != null) {
        $aObject["sat"] = $this->_iSaturation;
      }
      if ($this->_iBrightness != null) {
        $aObject["bri"] = $this->_iBrightness;
      }
      
      $sJson = json_encode($aObject, JSON_FORCE_OBJECT);
      
      if ($bTest) {
        echo "DEVICEACTION HUE CONNECT: " . $sUrl . " , JSON: " . $sJson . "\n";
      } else {
        //Send request to HUE bridge
        $curlObj = curl_init($sUrl);
  
        curl_setopt($curlObj, CURLOPT_HTTPHEADER, array('Content-Type: application/json','Content-Length: ' . strlen($sJson)));
        curl_setopt($curlObj, CURLOPT_CUSTOMREQUEST, "PUT");
        curl_setopt($curlObj, CURLOPT_RETURNTRANSFER, true);  
        curl_setopt($curlObj, CURLOPT_POSTFIELDS,$sJson);
  
        $sResult = curl_exec($curlObj);
        $oData = json_decode($sResult);
      } 
    }
  }
  
  public function getDuration() {
    return $this->_iTime;
  }
  
  public function getActiontype() {
    return "DeviceAction";
  }
  
  public function readXml($oAction) {
    $this->_sName = $oAction->getAttribute("name");
    
    foreach ($oAction->childNodes as $oChild) {
      if ($oChild->tagName == "status") {
        if ($oChild->textContent == "on" || $oChild->textContent == "off") {
          $this->_sStatus = $oChild->textContent;
        } else {
          die("Status is not on or off in DeviceAction on line " . $oChild->getLineNo() . "\n");
        }
      } else if ($oChild->tagName == "time") {
        if (is_numeric($oChild->textContent)) {
          $this->_iTime = $oChild->textContent;
        } else {
          die("Time is not numeric in DeviceAction on line " . $oChild->getLineNo() . "\n");
        }
      } else if ($oChild->tagName == "hsb") {
        $sValues = explode(",", $oChild->textContent);
        if (sizeof($sValues) != 3) {
          die("Incorrect HSB value given, supply 3 numbers like this 'x, y, z' on line " . $oChild->getLineNo() . "\n");
        }
        
        if (is_numeric($sValues[0]) && $sValues[0] > 0 && $sValues[0] <= 65535) {
          $this->_iHue = intval(trim($sValues[0]));
        } else {
          die("Hue is not numeric, or <= 0 or greater than 65535 in DeviceAction on line " . $oChild->getLineNo() . "\n");
        }
        if (is_numeric($sValues[1]) && $sValues[1] > 0 && $sValues[1] <= 255) {
          $this->_iSaturation = intval(trim($sValues[1]));
        } else {
          die("Saturation is not numeric, or <= 0 or greater than 255 in DeviceAction on line " . $oChild->getLineNo() . "\n");
        }
        if (is_numeric($sValues[2]) && $sValues[2] > 0 && $sValues[2] <= 255) {
          $this->_iBrightness = intval(trim($sValues[2]));
        } else {
          die("Brightness is not numeric, or <= 0 or greater than 255 in DeviceAction on line " . $oChild->getLineNo() . "\n");
        }
      }
    }
    
    if ($this->_sName == null) {
      die("No name defined in DeviceAction on line  " . $oAction->getLineNo() . "\n");
    }
    
    if ($this->_sStatus == null) {
      die("No status defined in DeviceAction on line  " . $oAction->getLineNo() . "\n");
    }
  }
  
  public function writeXml($iLevel = 1) {
    $sRetVal = $this->formatXml($iLevel, "<" . $this->getActiontype() 
      . " name=\"" . $this->_sName . "\""
      . " type=\"hue\">");
  
    $sRetVal .= $this->formatXml($iLevel+1, "<status>" . $this->_sStatus . "</status>");  
    $sRetVal .= $this->formatXml($iLevel+1, "<time>" . $this->_iTime . "</time>");
    if ($this->_iHue != null || $this->_iSaturation != null || $this->_iBrightness != null) {
      $sRetVal .= $this->formatXml($iLevel+1, "<hsb>" . $this->_iHue . ", " . $this->_iSaturation . ", " . $this->_iBrightness . "</hsb>");
    }
        
    $sRetVal .= $this->formatXml($iLevel, "</" . $this->getActiontype() . ">");  
  
    return $sRetVal;
  }
}