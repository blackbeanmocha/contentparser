<?php

class Content {
  
	public $key;
	public $userName;
	public $fileName;
	public $startTime;
	public $endTime;
	public $platform;
	public $parserProfiles;
	public $tsExtractedPath; //Contains logfiles extracted path
  
	public function __construct($userName, $key, $fileName, $platform, $startTime, $endTime) {
		
		$this->userName = $name;
		$this->key = $key;
		$this->fileName = $fileName;
		$this->platform = $platform;
		$this->startTime = $startTime;
		$this->endTime = $endTime;
		$parserProfiles = array();
	}

	public function addParserProfile($parserProfile) {
		
		array_push($this->parserProfiles, $parserProfile);
	}
  
	public function setExtractedPath($path) {
		
		$this->tsExtractedPath = $path;
	}
  
}
?>
