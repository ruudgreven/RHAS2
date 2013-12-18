<?php
class Par extends ActionGroup {

  public function run($bTest = false) {
    foreach ($this->_aChildren as $oChild) {
      $oChild->run($bTest);
    }
    sleep($this->getDuration() / 1000);
  }
  
  public function getDuration() {
    $iTotal = 0;
    foreach ($this->_aChildren as $oChild) {
      $iDuration = $oChild->getDuration();
      if ($iDuration > $iTotal) {
        $iTotal = $iDuration;
      }
    }
    return $iTotal;
  }
  
  public function getActiontype() {
    return "par";
  }
}
?>