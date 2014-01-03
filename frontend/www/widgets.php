<?php
  //Check supplied file
  if (!isset($_GET['file'])) {
    die("Please supply a valid filename in the url with ?file=<filename>");
  }
  if (preg_match('/[^a-z_\-0-9]/i', $_GET['file'])) {
    die("Please supply a valid filename, located in /conf/widgets/ with the extension .json. Use A-Z, a-z OR 0-9 only");
  }
  $sFile = dirname(__FILE__) . "/../conf/widgets/" . $_GET['file'] . ".json";
  if (!file_exists($sFile)) {
    die("Please supply a valid filename, located in /conf/widgets/ with the extension .json");
  }
  
  //Parse supplied file
  $sJsonString = file_get_contents($sFile);
  $oJson = json_decode($sJsonString, true);
  
  //Read widget include file
  if (!isset($oJson["type"])) {
    die("Please check the format of your JSON file");
  }
  
  $sWidgetFile = dirname(__FILE__) . "/../inc/widgets/" . $oJson["type"] . ".php";
  if (!file_exists($sWidgetFile)) {
    die("Please supply a valid widget type in the JSON config file");
  }
  
  //Include widget file
  $aContent = $oJson['content'];
  require_once($sWidgetFile);
?>