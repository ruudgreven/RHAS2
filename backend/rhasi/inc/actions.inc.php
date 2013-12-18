<?php  
  /**
   * Runs the given actions, for example:
   
      <action id="bioscoop">
        <par>
          <device type="kaku" id="kerstboom">
            <status>on</status>
          </device>
          <device type="hue" id="staandelamp">
            <status>on</status>
            <rgb>#FFDDDD</rgb>
            <time>1000</time>
          </device>
        </par>
      </action>
   **/
  function parseAndRunAction($oAction, $bTest = false) {
    echo("<action id=\"" . $oAction->getAttribute('id') . "\">\n");
    $oParent = new Seq();
    $oParent->readXml($oAction);
    
    echo($oParent->writeXml());
    echo("</action>\n");
    
    if ($bTest) {
      echo "\n---\n";
      $oParent->run(true);
    } else {
      $oParent->run(false);
    }
  }
  
  /**
   * Run an action on a kaku device
   * @param $oDevice The device xml part. Can contain a status and time child.
   * @param $bWait Specify if the script should wait until completion
   
      <device type="kaku" id="kerstboom">
        <status>on</status>
        <time>1000</time>   //The time to wait after doing the action
      </device>
    
   */
  function doKakuAction($oDevice, $bWait, $iLevel) {
    rhalilog($iLevel, "Start action on device " . $oDevice->getAttribute("id"));
    if ($oDevice->hasAttribute("time")) {
      if ($bWait) {
        sleep($oDevice->getAttribute("time"));
      }
    }
  }
?>