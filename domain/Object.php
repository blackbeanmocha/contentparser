<?php

class Object{

	public $name;
	public $type;
	public $object_strings;
	public $object_operators;
	
	public function __construct($type){
		
		$this->type =  trim($type);
		$this->object_strings = array();
		$this->object_operators = array();
	}

	public function addObjectString($object_string) {
		
		array_push($this->object_strings, $object_string);
	}

	public function addObjectOperator($object_operator) {
		
		array_push($this->object_operators, $object_operator);	
	}
  
	public function getObjectString($name) {
    
		foreach($this->object_strings as $objString) {
			if($objString->name == $name)
				return $objString;
		}
    
	}
}

?>