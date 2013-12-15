<?php
  
Class SystemUtil {
  
  public static function executeCommand($command) {
    $results = array();
    $ret_val = null;
    print "\nRunning Command: $command \n";
    exec($command, $results, $ret_val);
    if($ret_val != 0) {
      die("Command: $command failed");
    }
    return $results;
  }
}
  
?>