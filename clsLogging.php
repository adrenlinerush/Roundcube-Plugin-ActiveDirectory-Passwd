<? php
/*
Logging Class 
Written by: adrenlinerush (Austin D. Mount)
For Use at Countrystone Inc.
Released under GPL

Usage:
On construct define a configuration php file
config file must include 3 variables
$logfile => where to write errors to
$debuglogfile => where to write debugging information
$debug => booleon as whether to write debugging information
*/


class Logging {
  public function _construct($config) {
      include($conifg);
  }
  funtion writelog ($data) {
    $dtStamp = date("m/d/y: H:i:s", time());
    file_put_contents($logfile,"$dtStamp: $data\n", FILE_APPEND | LOCK_EX);
  }

  function debugwrite ($data) {
    if ($debug) {
      $dtStamp = date("m/d/y: H:i:s", time());
      file_put_contents($debuglogfile,"$dtStamp: $data\n", FILE_APPEND | LOCK_EX);
    }
  }
}

?>
