<?php 
date_default_timezone_set('America/Los_Angeles');

class ContentHelper {
  
	private $content;
  
	public function __construct($content) {
		$this->content = $content;
	}
  
	function matchCounters() {

		$pattern = "";	
		foreach($this->content->parserProfiles as $parserProfile) {						
			foreach($parserProfile->object_array as $objects) {
				foreach ($objects->object_strings as $object_string) {
					$pattern .= ":".$object_string->name."|";
				}
			
			}	
		}
		$pattern .= '--- panio'. '|Elapsed time since last sampling';
		$extractedPath = $this->content->tsExtractedPath;
		$command = "find $extractedPath -name '*dp-monitor*' -print | xargs egrep -wri -h '$pattern' ";
		//$command = "egrep -wri '$pattern' $extractedPath/opt/var.dp0/log/pan/dp-monitor.log";
		$objStrings_map = $this->getObjectStringsMap();
  
		print "\n Before Parsing: \n";
		print_r($objStrings_map);
  
		$results = SystemUtil::executeCommand($command);
        
        $isValidTime = false;
		$isValidSamplingRate = false;
        
        foreach($results as $match) {
		    //print "\n $match";
            $currTime = "";
			if (strpos($match, '--- panio') !== false) {
                $timeDetails = preg_split("/[---]/", $match);
                $currTime = trim(trim($timeDetails[0]), ":");
                $isValidTime = $this->isValidTime($currTime);
			}
            
            if(strpos($match, "sampling") && $isValidTime) {
                preg_match("/(\d+.\d+)/", $match, $samplingDetails);
                $samplingRate = $samplingDetails[0];
                $isValidSamplingRate = $this->isValidSamplingRate($samplingRate);
            }
            
            if($isValidTime && $isValidSamplingRate) {
                //print "\n $match";
                $matchers = preg_split("/[\s::]+/", $match);
                $objStrings = $objStrings_map[$matchers[1]];
			
                if(sizeof($objStrings) > 0) {
    				foreach($objStrings as $objString) {
                        $objString->validateOccurence($matchers[2]);
    				}
    			}
            }                
		}	
  
		print "\n After Parsing: \n";
		print_r($objStrings_map);
        
        $file = "output.xml";
        $xml = XMLSerializer::generateValidXmlFromArray($objStrings_map);
        file_put_contents($file, $xml);
	}
  
	public function getObjectStringsMap() {
  
		$obj_strings_map=array();
		foreach($this->content->parserProfiles as $parserProfile) {	
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
    
    public function isValidTime($currTime) {
        
        if (strtotime($this->content->startTime) <= strtotime($currTime)
            && strtotime($this->content->endTime) >= strtotime($currTime)) {
                //print "\n Valid Time: $currTime";
                return true;
        }
        return false;
    }
    
    public function isValidSamplingRate($samplingRate) {
            
        if($samplingRate < 10) {
            return true;
        }
        return false;
    }
    
}
?>