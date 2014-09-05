<?php
date_default_timezone_set('America/Los_Angeles');

class PappsRequestHandler
{

    private $pappsRequest;

    public function __construct($pappsRequest)
    {
        $this->pappsRequest = $pappsRequest;
    }

    function match()
    {

        $pattern = "";
        foreach ($this->pappsRequest->profiles as $profile) {
            foreach ($profile->objects as $object) {
                $pattern .= ":" . $object->objectString . "|";
            }

        }

        //$pattern .= '--- panio'. '|Elapsed time since last sampling';

        $pattern .= ParserConstants::GLOBAL_PANIO_STMT . '|' . ParserConstants::SAMPLING_RATE_STMT;

        print "\n Pattern: $pattern \n";

        $extractedPath = "I_Donno";

        //$command = "find $extractedPath -name '*dp-monitor*' -print | xargs egrep -wri -h '$pattern' ";
        $command = "find $extractedPath -name \"" . ParserConstants::MONITOR_FILES_PATTERN . "\" -print | xargs egrep -wri -h '$pattern' ";
        //$command = "egrep -wri '$pattern' $extractedPath/opt/var.dp0/log/pan/dp-monitor.log";
        $resultMap = $this->getResultMap();

        print "\n Before Parsing: \n";
        print_r($resultMap);

        $results = SystemUtil::executeCommand($command);

        $isValidTime = false;
        $isValidSamplingRate = false;

        foreach ($results as $match) {

            if (strpos($match, ParserConstants::GLOBAL_PANIO_STMT) !== false) {
                $timeDetails = preg_split(ParserConstants::GLOBAL_PANIO_SPLIT_PATTERN, $match);
                $currTime = trim(trim($timeDetails[0]), ":");
                $isValidTime = $this->isValidTime($currTime);
            }

            if (strpos($match, ParserConstants::SAMPLING_RATE_STMT) && $isValidTime) {
                preg_match(ParserConstants::SAMPLING_RATE_SPLIT_PATTERN, $match, $samplingDetails);
                $samplingRate = $samplingDetails[0];
                $isValidSamplingRate = $this->isValidSamplingRate($samplingRate);
            }

            //print "\n isValidTime: $isValidTime && isValidSamplingRate: $isValidSamplingRate \n";

            if ($isValidTime && $isValidSamplingRate) {
                $matchers = preg_split(ParserConstants::COUNTER_STMT_SPLIT_PATTERN, $match);
                $objCounters = $resultMap[$matchers[1]];

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
        $showResult = $this->applyObjectOperators($resultMap);

        if (!$showResult) {
            print "\n Criteria is not matched !!\n";
        }

        $file = "testdata/output.xml";
        $xml = XMLSerializer::generateValidXmlFromArray($resultMap);
        file_put_contents($file, $xml);
    }

    public function applyObjectOperators($resultMap)
    {
        $prevOperator = NULL;
        $isValid = false;

        // 1. Read profile and get all objectStrings in order
        // 2. Keep a hashmap of all objectStrings and index of already read object counters
        // 3. Apply operation.
        $objStringPostionMap = array();
        foreach ($this->pappsRequest->profiles as $profile) {
            foreach ($profile->objects as $object) {
                $currpos = $objStringPostionMap[$object->objectString];
                if ($currpos == null) {
                    $currpos = 0;
                } else {
                    $currpos = $currpos + 1;
                }
                $objStringPostionMap[$object->objectString] = $currpos;
                $objCounters = $resultMap[$object->objectString];
                $objectCounter = $objCounters[$currpos];

                $currCounter = $objectCounter->getCounter();

                if (!isset($prevOperator)) {
                    $prevOperator = $objectCounter->object->objectOperator;
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
        $resultMap = array();
        foreach ($this->pappsRequest->profiles as $profile) {
            foreach ($profile->objects as $object) {
                $key = $object->objectString;
                $value = $resultMap[$key];
                if ($value == null) {
                    $value = array();
                }
                array_push($value, new ObjectCounter($object));
                $resultMap[$key] = $value;
            }
        }
        return $resultMap;
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

}

?>