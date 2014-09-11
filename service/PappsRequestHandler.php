<?php
date_default_timezone_set('America/Los_Angeles');
ini_set('memory_limit', '-1');

class PappsRequestHandler
{

    private $pappsRequest;
    private $resultMap;

    public function __construct($pappsRequest)
    {
        $this->pappsRequest = $pappsRequest;
    }


    function matchObject($objectString, $objectLogFiles, $considerTimeRange, $extractedPath) {

        $pattern = ":" . $objectString ;
        $pattern .=  '|' . ParserConstants::GLOBAL_PANIO_STMT . '|' . ParserConstants::SAMPLING_RATE_STMT;

        print "\n Pattern: $pattern \n";

        $logFilesArray = explode(",", $objectLogFiles);

        $logFilesPattern = "";

        if(count($logFilesArray) == 1) {
            $logFilesPattern .= "-name \"*$objectLogFiles*\" ";
        } else {
            $logFilesPattern .= "\\( ";
            foreach($logFilesArray as $filePattern) {
                $logFilesPattern .= "-name \"*$filePattern\" -o ";
            }
            $logFilesPattern = rtrim($logFilesPattern, " -o");
            $logFilesPattern .= " \\)";
        }

        $command = "find $extractedPath $logFilesPattern -print | xargs egrep -wri -h '$pattern' ";
        $results = SystemUtil::executeCommand($command);

        $resultMap = $this->getResultMap();

        $isValidTime = false;
        $isValidSamplingRate = false;

        //print "Consider Time Range: $considerTimeRange";

        if(!$considerTimeRange) {
            $isValidTime = true;
        }

        foreach ($results as $match) {

            if ($considerTimeRange &&
                strpos($match, ParserConstants::GLOBAL_PANIO_STMT) !== false) {
                preg_match(ParserConstants::GLOBAL_PANIO_SPLIT_PATTERN, $match, $timeDetails);
                $currTime = trim($timeDetails[0]);
                $isValidTime = $this->isValidTime($currTime);
            }

            if (strpos($match, ParserConstants::SAMPLING_RATE_STMT) && $isValidTime) {
                preg_match(ParserConstants::SAMPLING_RATE_SPLIT_PATTERN, $match, $samplingDetails);
                $samplingRate = $samplingDetails[0];
                $isValidSamplingRate = $this->isValidSamplingRate($samplingRate);
            }

            //print "\n isValidTime: $isValidTime && isValidSamplingRate: $isValidSamplingRate \t match:$match\n";

            if ($isValidTime && $isValidSamplingRate) {
                $matchers = preg_split(ParserConstants::COUNTER_STMT_SPLIT_PATTERN, $match);

                //print "\n isValidTime: $isValidTime && isValidSamplingRate: $isValidSamplingRate \t match:$match\n";

                $objCounters = isset($resultMap[$matchers[1]]) ? $resultMap[$matchers[1]] : array();

                if (sizeof($objCounters) > 0) {
                    foreach ($objCounters as $objCounter) {
                        $objCounter->validateOccurence($matchers[2]);
                    }
                }
            }
        }
    }


    function matchAll() {

        $extractedPath = $this->extractTar();
        $resultMap = $this->getResultMap();
        print "\n Before Parsing: \n";
        print_r($resultMap);

        $considerTimeRange = true;

        if(!$this->isValidDateTimeString($this->pappsRequest->startTime)
            || !$this->isValidDateTimeString($this->pappsRequest->startTime)) {
            $considerTimeRange = false;
        }

        foreach ($this->pappsRequest->profiles as $profile) {
            foreach ($profile->objects as $object) {
                print "\n now parsing $object->objectString \n";
                $logFile = (isset($object->objectLogFiles) && !empty($object->objectLogFiles)) ? $object->objectLogFiles : "dp-monitor";
                $this->matchObject($object->objectString, $logFile, $considerTimeRange, $extractedPath);
            }

        }

        $resultMap = $this->getResultMap();

        print "\n After Parsing: \n";
        print_r($resultMap);

        // Apply object operator to get final output
        $showResult = $this->applyLogicalOperators($resultMap);

        if (!$showResult) {
            print "\n Criteria is not matched !!\n";
        }

        $outputFile = str_replace("%s", $this->pappsRequest->requestId ,ParserConstants::OUTPUT_XML);
        $xml = XMLSerializer::generateValidXmlFromArray($resultMap);
        file_put_contents($outputFile, $xml);

        $this->clean($extractedPath);
    }

    function match()
    {

        $pattern = "";
        foreach ($this->pappsRequest->profiles as $profile) {
            foreach ($profile->objects as $object) {
                $pattern .= ":" . $object->objectString . "|";
            }

        }

        $pattern .= ParserConstants::GLOBAL_PANIO_STMT . '|' . ParserConstants::SAMPLING_RATE_STMT;

        print "\n Pattern: $pattern \n";

        $extractedPath = $this->extractTar();

        //$command = "find $extractedPath -name '*dp-monitor*' -print | xargs egrep -wri -h '$pattern' ";
        $command = "find $extractedPath -name \"" . ParserConstants::MONITOR_FILES_PATTERN . "\" -print | xargs egrep -wri -h '$pattern' ";
        //$command = "egrep -wri '$pattern' $extractedPath/opt/var.dp0/log/pan/dp-monitor.log";
        $resultMap = $this->getResultMap();

        print "\n Before Parsing: \n";
        print_r($resultMap);

        $results = SystemUtil::executeCommand($command);

        $isValidTime = false;
        $isValidSamplingRate = false;

        // If start time or end time is not defined
        // search entire file.
        $considerTimeRange = true;

        if(!$this->isValidDateTimeString($this->pappsRequest->startTime)
           || !$this->isValidDateTimeString($this->pappsRequest->startTime)) {
            $considerTimeRange = false;
            $isValidTime = true;
        }

        foreach ($results as $match) {

            if ($considerTimeRange &&
                strpos($match, ParserConstants::GLOBAL_PANIO_STMT) !== false) {
                preg_match(ParserConstants::GLOBAL_PANIO_SPLIT_PATTERN, $match, $timeDetails);
                $currTime = trim($timeDetails[0]);
                $isValidTime = $this->isValidTime($currTime);
            }

            if (strpos($match, ParserConstants::SAMPLING_RATE_STMT) && $isValidTime) {
                preg_match(ParserConstants::SAMPLING_RATE_SPLIT_PATTERN, $match, $samplingDetails);
                $samplingRate = $samplingDetails[0];
                $isValidSamplingRate = $this->isValidSamplingRate($samplingRate);
            }

            //print "\n isValidTime: $isValidTime && isValidSamplingRate: $isValidSamplingRate \t match:$match\n";

            if ($isValidTime && $isValidSamplingRate) {
                $matchers = preg_split(ParserConstants::COUNTER_STMT_SPLIT_PATTERN, $match);
                $objCounters = isset($resultMap[$matchers[1]]) ? $resultMap[$matchers[1]] : array();

                if (sizeof($objCounters) > 0) {
                    foreach ($objCounters as $objCounter) {
                        $objCounter->validateOccurence($matchers[2]);
                    }
                }
            }
        }

        print "\n After Parsing: \n";
        print_r($resultMap);

        // Apply object operator to get final output
        $showResult = $this->applyLogicalOperators($resultMap);

        if (!$showResult) {
            print "\n Criteria is not matched !!\n";
        }

        $outputFile = str_replace("%s", $this->pappsRequest->requestId ,ParserConstants::OUTPUT_XML);
        $xml = XMLSerializer::generateValidXmlFromArray($resultMap);
        file_put_contents($outputFile, $xml);

        $this->clean($extractedPath);
    }

    public function applyLogicalOperators($resultMap)
    {
        $prevOperator = NULL;
        $isValid = false;

        // 1. Read profile and get all objectStrings in order
        // 2. Keep a hashmap of all objectStrings and index of already read object counters
        // 3. Apply operation.
        $objStringPostionMap = array();
        foreach ($this->pappsRequest->profiles as $profile) {
            foreach ($profile->objects as $object) {
                $currpos = 0;
                if (array_key_exists($object->objectString,$objStringPostionMap)) {
                    $currpos = $objStringPostionMap[$object->objectString];
                    $currpos = $currpos + 1;
                }

                $objStringPostionMap[$object->objectString] = $currpos;
                $objCounters = $resultMap[$object->objectString];
                $objectCounter = $objCounters[$currpos];

                $currCounter = $objectCounter->getCounter();

                if (!isset($prevOperator)) {
                    $prevOperator = $objectCounter->object->logicalOperator;
                    $isValid = isset($currCounter) & ($currCounter > 0 ? true : false);
                    continue;
                }

                if ($prevOperator == "and") {
                    $isValid = ($isValid & ((isset($currCounter) & $currCounter > 0) ? true : false));
                } elseif ($prevOperator == "or") {
                    $isValid = ($isValid | ((isset($currCounter) & $currCounter > 0) ? true : false));
                }
            }
        }
        return $isValid;
    }


    public function getResultMap()
    {
        if (!isset($this->resultMap) || empty($this->resultMap)) {
            $this->resultMap = array();
            foreach ($this->pappsRequest->profiles as $profile) {
                foreach ($profile->objects as $object) {
                    $key = $object->objectString;
                    $value = $this->resultMap[$key];
                    if ($value == null) {
                        $value = array();
                    }
                    array_push($value, new ObjectCounter($object));
                    $this->resultMap[$key] = $value;
                }
            }
        }
        return $this->resultMap;
    }

    public function isValidTime($currTime)
    {
        if (strtotime($this->pappsRequest->startTime) <= strtotime($currTime)
            && strtotime($this->pappsRequest->endTime) >= strtotime($currTime)
        ) {
            return true;
        }
        return false;
    }

    public function isValidSamplingRate($samplingRate)
    {

        if ($samplingRate < 10) {
            return true;
        }
        return false;
    }

    public function extractTar() {

        $path = ParserConstants::TS_FILES_PATH;
        $pathTo = "";
        if (isset($this->pappsRequest->tsPath)) {
            $pathTo = $path."/".$this->pappsRequest->userName."-".
                $this->pappsRequest->requestId."-".preg_replace('/\\.[^.\\s]{3,4}$/', '', $this->pappsRequest->tsPath);
            $path = $path . "/" . $this->pappsRequest->tsPath;

            if(!file_exists($path)) {
                die("File: $path doesn't exist");
            }
            try {
                $tech_support = new PharData($path);
                print "Extracting the tech support file..Have patience!\n";
                $tech_support->extractTo($pathTo, null, true);
                print "Thank you for your patience. You can view the files now in $pathTo \n";
            } catch (Exception $e) {
                print "$e \n";
            }

        }

        return $pathTo;
    }


    function isValidDateTimeString($str_dt)
    {
        //print "\nGot: $str_dt \n";
        preg_match("/(0{4})-(0{2})-(0{2}) (0{2}):(0{2}):(0{2})/", $str_dt, $validDate);
        if (isset($validDate) && !empty($validDate)) {
            print "\n woohoo !\n";
            return false;
        }
        return true;
    }

    public function clean($extractedPath) {

        // delete extracted folder
        system('/bin/rm -rf ' . escapeshellarg($extractedPath));
    }

}

?>