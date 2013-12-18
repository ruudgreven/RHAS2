<?php
class DeviceActionKaku extends Action {
  private $_sName = null;
  private $_sStatus = null;
  private $_iTime = 50;
  
  public function __construct() {
    
  }
  
  public function run($bTest = false) {
    $sId = null;
    //Find device id
    $oMysqli = getMysqli();
    if ($stmt = $oMysqli->prepare("SELECT id FROM hw_switches WHERE name=?")) {
      $stmt->bind_param("s", $this->_sName);
      $stmt->execute();
      $stmt->bind_result($sId);
      $stmt->fetch();
      $stmt->close();
      
      //Send request to homewizard
      $sUrl = "http://" . CONFIG_HW_HOST . ":" . CONFIG_HW_PORT . "/" . CONFIG_HW_PASSWORD . "/sw/" . $sId . "/" . $this->_sStatus;  
    
      if ($bTest) {
        echo "DEVICEACTION KAKU CONNECT: " . $sUrl . "\n";
      } else {
        $oData = getJSON($sUrl);
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
      . " type=\"kaku\">");
  
    $sRetVal .= $this->formatXml($iLevel+1, "<status>" . $this->_sStatus . "</status>");  
    $sRetVal .= $this->formatXml($iLevel+1, "<time>" . $this->_iTime . "</time>");  
        
    $sRetVal .= $this->formatXml($iLevel, "</" . $this->getActiontype() . ">");  
  
    return $sRetVal;
  }
}