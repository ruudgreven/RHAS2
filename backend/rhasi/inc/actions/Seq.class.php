<?php
class Seq extends ActionGroup {
  private $_iLoop = 1;

  public function run($bTest = false) {
    for ($i = 0; $i < $this->_iLoop; $i++) {
      foreach ($this->_aChildren as $oChild) {
        $oChild->run($bTest);
        if ($oChild->getActiontype() != "par" && $oChild->getActiontype() != "seq") {
          sleep($oChild->getDuration() / 1000);
        }
      }
    }
  }
  
  public function getDuration() {
    $iTotal = 0;
    foreach ($this->_aChildren as $oChild) {
      $iDuration = $oChild->getDuration();
      $iTotal = $iTotal + $iDuration;
    }
    return $iTotal;
  }
  
  public function readXml($oAction) {
    if ($oAction->hasAttribute("loop")) {
      if (is_numeric($oAction->getAttribute("loop"))) {
        $this->_iLoop = $oAction->getAttribute("loop");
      } else {
        die("Loop is not a numeric on line " . $oChild->getLineNo() . "\n");
      }
    }
    parent::readXml($oAction);
  }
  
  public function getActiontype() {
    return "seq";
  }
}
?>