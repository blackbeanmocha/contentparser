<?php

class ParserProfile{

	public $name;
	public $object_array;
	
	public function __construct($name) {
		$this->name = $name;
		$this->object_array = array();
	}

	public function addObject($object) {
		array_push($this->object_array, $object);
	}
}

?>