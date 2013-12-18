<?php
abstract class Action {
  abstract public function run($bTest = false);
  abstract public function getDuration();
  abstract public function getActiontype();
  
  abstract public function readXml($oAction);
  abstract public function writeXml($iLevel = 1);
  
  public function formatXml($iLevel, $sXml) {
    $sRetVal = "";
    for ($i = 0; $i < $iLevel; $i++) {
      $sRetVal .= "  ";
    }
    return $sRetVal . $sXml . "\n";
  }
}
?>