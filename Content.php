<?php

class Content {
  
  public $key;
  public $userName;
  public $startTime;
  public $endTime;
  public $parserProfiles;
  public $fileName;
  
   public function __construct($userName, $key, $startTime, $endTime, $fileName) {
		$this->userName = $name;
		$this->key = $key;
		$this->fileName = $fileName;
    $this->startTime = $startTime;
    $this->endTime = $endTime;
    $parserProfiles = array();
	}

  public function addParserProfile($parserProfile) {
    array_push($this->parserProfiles, $parserProfile);
  }
  
  public function getObjectStringsMap() {
    $obj_strings_map=array();
    foreach($this->parserProfiles as $parserProfile) {	
      foreach($parserProfile->object_array as $object) {
        foreach($object->object_strings as $objStr) {
          $key = $objStr->name;
          $value = $obj_strings_map[$key];
          if($value == null) {
              $value = array();            
          } 
          array_push($value, $objStr);
          $obj_strings_map[$key] = $value;
        }
      }
    }
    return $obj_strings_map;
  }
  
}
?>
