<?php
  
Class ContentFactory {
  
	public function initialize($fileName) {
    	
		if(!file_exists($fileName)) {
			die("File: $fileName doesn't exist");
		}
		$my_xml = simplexml_load_file($fileName);
		$user_name = $my_xml->username;
		$ts_file_name = $my_xml->file;
		$key = $my_xml->key;
		$startTime = $my_xml->startTime;
		$endTime = $my_xml->endTime;
		$platform = $my_xml->platform;     

		$content = new Content($user_name, $key, $ts_file_name, $platform, $startTime, $endTime);
		$this->loadParserProfiles($my_xml, $content); 
		$this->extractArchiveFile($content);
		return $content;
	}
  
	protected function loadParserProfiles($my_xml, $content){
	
		$parser_profiles_list = array();
		foreach ($my_xml->parserProfile as $parser_profile_xml) {
			$parserProfile = new ParserProfile($parser_profile_xml[ParserConstants::NAME]);	
			foreach ($parser_profile_xml->object as $parse_object_xml) {
				$objectType = $parse_object_xml[ParserConstants::TYPE];
				$objectString = null;
				$object = new Object($objectType);
				foreach ($parse_object_xml->objectString as $parse_object_string_xml) {
					if($objectType == ObjectType::COUNTER) {
						$objectString = new Counter($parse_object_string_xml[ParserConstants::NAME], 
						$parse_object_string_xml->threshold, 
						$parse_object_string_xml->operator);

					} else {
						//regex TODO
					}

					$object->addObjectString($objectString);
				}
				// iterate object operators
				foreach ($parse_object_xml->objectOperator as $parse_object_operator_xml) {
					$object->addObjectOperator($parse_object_operator_xml[ParserConstants::LOGICAL_OP]);
				}			
				$parserProfile->addObject($object);
			}
			array_push($parser_profiles_list, $parserProfile);
		}
		$content->parserProfiles = $parser_profiles_list;
	}
  
	private function getPathToExtract($content) {
    
		$path = pathinfo(realpath($content->fileName), PATHINFO_DIRNAME).'/'.$content->key;
		return $path; 
	}

	/* Unzip the tech support file */
	protected function extractArchiveFile($content) {
    	
		$path = $this->getPathToExtract($content);
		// try {
			// 			$tech_support = new PharData($content->fileName);
			// 			print "Extracting the tech support file..Have patience!\n";
			// 			$tech_support->extractTo("$path", null, true);
			// 			print "Thank you for your patience. You can view the files now in $path \n";
			// 		} catch(Exception $e) {
				// 			print "$e \n";
				// 		}
				$content->setExtractedPath($path);
			} 
		} 
		?>