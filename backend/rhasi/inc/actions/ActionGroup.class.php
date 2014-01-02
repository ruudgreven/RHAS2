<?php
abstract class ActionGroup extends Action {
  protected $_aChildren;
  
  public function __construct() {
    $this->_aChildren = array();
  }
  
  public function readXml($oAction) {
    foreach ($oAction->childNodes as $oChild) {
      if ($oChild->tagName == "par") {
        $oPar = new Par();
        $oPar->readXml($oChild);
        array_push($this->_aChildren, $oPar);
      } else if ($oChild->tagName == "seq") {
        $oSeq = new Seq();
        $oSeq->readXml($oChild);
        array_push($this->_aChildren, $oSeq);
      } else if ($oChild->tagName == "deviceaction") {
        if ($oChild->getAttribute("type") == "kaku") {
          $oKakuAction = new DeviceActionKaku();
          $oKakuAction->readXml($oChild);
          array_push($this->_aChildren, $oKakuAction);
        } else if ($oChild->getAttribute("type") == "hue") {
          $oHueAction = new DeviceActionHue();
          $oHueAction->readXml($oChild);
          array_push($this->_aChildren, $oHueAction);
        }
      }
    }
  }
  
  public function writeXml($iLevel = 1) {
    $sRetVal = $this->formatXml($iLevel, "<" . $this->getActiontype() . " duration=\"" . $this->getDuration() . "\">");
    foreach ($this->_aChildren as $oChild) {
      $sRetVal .= $oChild->writeXml($iLevel + 1);
    }
    $sRetVal .= $this->formatXml($iLevel, "</" . $this->getActiontype() . ">");
    return $sRetVal;
  }
}
?>