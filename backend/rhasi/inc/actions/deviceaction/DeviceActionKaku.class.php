<?php
class DeviceActionKaku extends Action {
  private $_sId = null;
  private $_sStatus = null;
  private $_iTime = 50;
  
  public function __construct() {
    
  }
  
  public function run($bTest = false) {
  
  }
  
  public function getDuration() {
    return $this->_iTime;
  }
  
  public function getActiontype() {
    return "DeviceAction";
  }
  
  public function readXml($oAction) {
    $this->_sId = $oAction->getAttribute("id");
    
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
    
    if ($this->_sId == null) {
      die("No id defined in DeviceAction on line  " . $oAction->getLineNo() . "\n");
    }
    
    if ($this->_sStatus == null) {
      die("No status defined in DeviceAction on line  " . $oAction->getLineNo() . "\n");
    }
  }
  
  public function writeXml($iLevel = 1) {
    $sRetVal = $this->formatXml($iLevel, "<" . $this->getActiontype() 
      . " id=\"" . $this->_sId . "\""
      . " type=\"kaku\">");
  
    $sRetVal .= $this->formatXml($iLevel+1, "<status>" . $this->_sStatus . "</status>");  
    $sRetVal .= $this->formatXml($iLevel+1, "<time>" . $this->_iTime . "</time>");  
        
    $sRetVal .= $this->formatXml($iLevel, "</" . $this->getActiontype() . ">");  
  
    return $sRetVal;
  }
}