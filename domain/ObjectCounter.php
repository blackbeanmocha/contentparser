<?php
/**
 * Created by PhpStorm.
 * User: zarina
 * Date: 9/4/14
 * Time: 9:44 PM
 */

class ObjectCounter {

    public $object;
    private $counter; // counts occurances of object string based on threshold

    public function __construct($object) {
        $this->object = $object;
        $this->counter = 0;
    }

    /**
     * @return mixed
     */
    public function getCounter()
    {
        return $this->counter;
    }


    public function validateOccurence($extractedValue) {
        $is_valid = false;
        $threshold = $this->object->objectThreshold;
        switch($this->object->objectThresholdOperator){
            case ">":
                $is_valid = $extractedValue > $threshold;
                break;
            case ">=":
                $is_valid = $extractedValue >= $threshold;
                break;
            case "<":
                $is_valid = $extractedValue < $threshold;
                break;
            case "<=":
                $is_valid = $extractedValue <= $threshold;
                break;
            case "=":
                $is_valid = $extractedValue == $threshold;
                break;
        }
        if ($is_valid)  {
            $this->counter++;
            return true;
        }
        return false;
    }
}
?>