<?php
  require_once(dirname(__FILE__) . "/commons.inc.php");
  require_once(dirname(__FILE__) . "/inc/actions.inc.php");

  function __autoload($sClassName) {
    //class directories
    $aDirecties = array(
      dirname(__FILE__) . "/inc/actions/",
      dirname(__FILE__) . "/inc/actions/deviceaction/",
    );
        
    foreach($aDirecties as $sDirectory) {
      if(file_exists($sDirectory.$sClassName . ".class.php")) {
        require_once($sDirectory.$sClassName . ".class.php");
        return;
      }            
    }
  }
  

  $sFile = $argv[1];
  if ($sFile == "") {
    echo "No file specified, use paths like 'actions/myaction.xml'\n";
    return;
  }
  if (substr($sFile, -4) != ".xml") {
    echo "No XML file specified\n";
    return;
  }

  $oDom = new DOMDocument();
  $oDom->load(dirname(__FILE__) . "/" . $sFile);


  //Read actions
  $oActions = $oDom->getElementsByTagName('action');  
  foreach ($oActions as $oAction) {
    parseAndRunAction($oAction, true);
  }

?>
