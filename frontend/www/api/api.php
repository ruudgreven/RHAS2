<?php
/**
 * RHAS2 API Dispatcher
 */
require_once(dirname(__FILE__) . "/../../../lib/flight/flight/Flight.php");
require_once(dirname(__FILE__) . "/../../../lib/Process.class.php");
require_once(dirname(__FILE__) . "/../../inc/commons.inc.php");

/**
 * Start the action with the given name
 */
Flight::route('GET /actions/@sActionName/start', function($sActionName){
    //Check if action exists
    if (preg_match('/[^a-z_\-0-9]/i', $sActionName)) {
      die("{\"status\": \"error\", \"message\", \"Please supply a valid actionname\"}");
    }
    $sActionFile = dirname(__FILE__) . "/../../../backend/rhasi/actions/" . $sActionName . ".xml";
    if (!file_exists($sActionFile)) {
      die("{\"status\": \"error\", \"message\", \"Please supply a valid actionname, file not found\"}");
    }
    
    //Run the action
    $sCommand = CONFIG_RHAS2_PATH . "/backend/rhasi/rhasi.sh actions/" . $sActionName . ".xml";
    $oProcess = new Process($sCommand);
    echo "{\"status\": \"ok\", \"message\", \"Process with name '" . $sActionName . "' started, pid: " . $oProcess->getPid() . "\"";
});

Flight::start();
?>
