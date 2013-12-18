<?php
class Seq extends ActionGroup {

  public function run($bTest = false) {
    foreach ($this->_aChildren as $oChild) {
      $oChild->run();
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
  
  public function getActiontype() {
    return "seq";
  }
}
?>