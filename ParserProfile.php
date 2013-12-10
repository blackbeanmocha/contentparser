<?php

class ParserProfile{

	public $name;
	public $object_array;
	public $platform;

	public function __construct($name, $platform) {
		$this->name = $name;
		$this->platform = $platform;
		$this->object_array = array();
	}

	public function addObject($object) {
		array_push($this->object_array, $object);
	}
}

?>