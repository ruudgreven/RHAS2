<?php
class Par extends ActionGroup {

  public function run($bTest = false) {
    
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