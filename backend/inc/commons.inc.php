<?php
require_once(dirname(__FILE__) . "/../../config.inc.php");

/**
 * Class autoloader
 */
function __autoload($sClassName) {
  //class directories
  $aDirecties = array(
    dirname(__FILE__) . "/../rhasi/inc/actions/",
    dirname(__FILE__) . "/../rhasi/inc/actions/deviceaction/",
  );
      
  foreach($aDirecties as $sDirectory) {
    if(file_exists($sDirectory.$sClassName . ".class.php")) {
      require_once($sDirectory.$sClassName . ".class.php");
      return;
    }            
  }
}
  
/**
 * An interface for the subscripts
 */
interface iSubscript
{
    public function execute($oMysqli);
}

/**
 * Returns a connection to mysql
 */
function getMysqli() {
  $oMysqli = new mysqli(CONFIG_DB_HOSTNAME, CONFIG_DB_USERNAME, CONFIG_DB_PASSWORD, CONFIG_DB_DATABASE);
  if (mysqli_connect_errno()) {
    die('{"status": "failed", "error": "'  . addslashes(mysqli_error()) . '"}');
  }
  return $oMysqli;
}

/**
 * This method can be used to get a JSON object from a resource
 */
function getJSON($sUrl) {
    //Read data from URL
    $oContext = stream_context_create(array('http' => array('header'=>'Connection: close\r\n')));
    $sData = file_get_contents($sUrl, false, $oContext);
    $oData = json_decode($sData);
    return $oData;
}
?>