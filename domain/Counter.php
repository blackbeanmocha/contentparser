<?php

class Counter{

	public $name;
	public $threshold;
	public $operator;
	public $occurrence;
  
	public function __construct($name, $threshold, $operator){
		$this->name = trim($name);
		$this->threshold = trim($threshold);
		$this->operator = trim($operator);
	}
  
	public function addOccurence() {
		$this->occurence++;
	}
  
	public function getOccurences() {
		return $this->occurence;
	}
  
	public function validateOccurence($extractedValue) {  
		$is_valid = false;
		switch($this->operator){
			case ">":
			$is_valid = $extractedValue > $this->threshold;
			break;
			case ">=":
			$is_valid = $extractedValue >= $this->threshold;
			break;      
			case "<":
			$is_valid = $extractedValue < $this->threshold;
			break;
			case "<=":
			$is_valid = $extractedValue <= $this->threshold;
			break;
			case "=":
			$is_valid = $extractedValue == $this->threshold;
			break;
		}
		if ($is_valid)  {
			$this->occurence++;
			return true;
		} 
		return false; 
	}
  
  
}

?>
