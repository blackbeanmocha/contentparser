<?php

/* include all relevant classes */
include "Content.php";
include "Object.php";
include "ObjectType.php";
include "Counter.php";
include "ParserProfile.php";
include "ParserConstants.php";

/** Global variables */
$content;

function get_ParserProfiles($my_xml){
	
	global $content;
  
  $parser_profiles_list = array();
	foreach ($my_xml->parserProfile as $parser_profile_xml) {
		$parserProfile = new ParserProfile($parser_profile_xml["name"], $parser_profile_xml->platform);
		
		foreach ($parser_profile_xml->object as $parse_object_xml) {
			$objectType = $parse_object_xml["type"];
			$objectString = null;
			
			$object = new Object($objectType);

			foreach ($parse_object_xml->objectString as $parse_object_string_xml) {
				if($objectType == ObjectType::COUNTER) {
					$objectString = new Counter($parse_object_string_xml["name"], 
									                    $parse_object_string_xml->threshold, 
									                    $parse_object_string_xml->operator);

				} else {
					//regex TODO
				}

				$object->addObjectString($objectString);
			}
			
			// iterate object operators
			foreach ($parse_object_xml->objectOperator as $parse_object_operator_xml) {
				$object->addObjectOperator($parse_object_operator_xml['logicalOp']);
			}
			
			$parserProfile->addObject($object);
		}

    	array_push($parser_profiles_list, $parserProfile);
    }
    $content->parserProfiles = $parser_profiles_list;
}

function get_ts_extract_path() {
	global $content;
	$path = pathinfo(realpath($content->fileName), PATHINFO_DIRNAME).'/'.$content->key;
	return $path; 
}

/*function check_platform(){
	$tech_support = extract_ts());
    

}
*/

/* Unzip the tech support file */
function extract_ts() {
	
	global $content;
	//$path = pathinfo(realpath($ts_file_name), PATHINFO_DIRNAME).'/'.$key;
	$path = get_ts_extract_path();
	try {
		$tech_support = new PharData($content->fileName);
		print "Extracting the tech support file..Have patience!\n";
		$tech_support->extractTo("$path", null, true);
		print "Thank you for your patience. You can view the files now in $path \n";
	} catch(Exception $e) {
		print "$e \n";
	}

}

function match_counter_using_grep ($path) {

	global $content;
	$pattern = "";
	
	foreach($content->parserProfiles as $parserProfile) {						
		foreach($parserProfile->object_array as $objects) {
			foreach ($objects->object_strings as $object_string) {
				$pattern .= ":".$object_string->name."|";
			}
			
		}	
	}
    
    // verify platform

    $platform = exec("find $path/tmp/cli -name 'techsupport*' | egrep -ri '^cfg.platform.model:' $path/tmp/cli");
    
    print "\n Platform:".substr($platform, -4)."\n";
	
	$pattern = rtrim($pattern,"|");

	$command = "find $path -name '*dp-monitor*' | egrep -wri '$pattern' $path";
	$results = array();

  $objStrings_map = $content->getObjectStringsMap();
  
  print "\n Before Parsing: \n";
  print_r($objStrings_map);
  
	exec($command, $results);
	
  foreach($results as $match) {
    $matchers = preg_split("/[\s::]+/", $match);
    $objStrings = $objStrings_map[$matchers[1]];
    foreach($objStrings as $objString) {
      $objString->validateOccurance($matchers[2]);
    }
	}	
  
  print "\n After Parsing: \n";
  print_r($objStrings_map);
}



# main function
$my_xml = simplexml_load_file("example.xml");

/*reading the contents of the xml file*/
$user_name = $my_xml->username;
$ts_file_name = $my_xml->file;
$key = $my_xml->key;     

$content = new Content($user_name, $key, " ", " ", $ts_file_name);

get_ParserProfiles($my_xml);

//extract_ts();

$ts_extracted_path = get_ts_extract_path();
match_counter_using_grep($ts_extracted_path);

?>