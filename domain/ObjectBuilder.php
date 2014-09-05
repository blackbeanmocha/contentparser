<?php
/**
 * Created by PhpStorm.
 * User: zarina
 * Date: 9/3/14
 * Time: 11:15 PM
 */

class ObjectBuilder {

    private $objectId;
    private $objectLabel;
    private $objectType;
    private $objectString;
    private $objectOperator;
    private $objectLogFiles;
    private $objectDescription;
    private $objectThreshold;
    private $objectThresholdOperator;
    private $objectTimeWindow;
    private $createdBy;
    private $createdDate;
    private $modifiedBy;
    private $modifiedDate;

    function __construct() {
    }

    /**
     * @param mixed $createdBy
     * @return ObjectBuilder builder object
     */
    function createdBy($createdBy)
    {
        $this->createdBy = $createdBy;
        return $this;
    }

    /**
     * @param mixed $createdDate
     * @return ObjectBuilder builder object
     */
    function createdDate($createdDate)
    {
        $this->createdDate = $createdDate;
        return $this;
    }

    /**
     * @param mixed $modifiedBy
     * @return ObjectBuilder builder object
     */
    function modifiedBy($modifiedBy)
    {
        $this->modifiedBy = $modifiedBy;
        return $this;
    }

    /**
     * @param mixed $modifiedDate
     * @return ObjectBuilder builder object
     */
    function modifiedDate($modifiedDate)
    {
        $this->modifiedDate = $modifiedDate;
        return $this;
    }

    /**
     * @param mixed $objectDescription
     * @return ObjectBuilder builder object
     */
    function objectDescription($objectDescription)
    {
        $this->objectDescription = $objectDescription;
        return $this;
    }

    /**
     * @param mixed $objectId
     * @return ObjectBuilder builder object
     */
    function objectId($objectId)
    {
        $this->objectId = $objectId;
        return $this;
    }

    /**
     * @param mixed $objectLabel
     * @return ObjectBuilder builder object
     */
    function objectLabel($objectLabel)
    {
        $this->objectLabel = $objectLabel;
        return $this;
    }

    /**
     * @param mixed $objectLogFiles
     * @return ObjectBuilder builder object
     */
    function objectLogFiles($objectLogFiles)
    {
        $this->objectLogFiles = $objectLogFiles;
        return $this;
    }

    /**
     * @param mixed $objectOperator
     * @return ObjectBuilder builder object
     */
    function objectOperator($objectOperator)
    {
        $this->objectOperator = $objectOperator;
        return $this;
    }

    /**
     * @param mixed $objectString
     * @return ObjectBuilder builder object
     */
    function objectString($objectString)
    {
        $this->objectString = $objectString;
        return $this;
    }

    /**
     * @param mixed $objectThreshold
     * @return ObjectBuilder builder object
     */
    function objectThreshold($objectThreshold)
    {
        $this->objectThreshold = $objectThreshold;
        return $this;
    }

    /**
     * @param mixed $objectThresholdOperator
     * @return ObjectBuilder builder object
     */
    function objectThresholdOperator($objectThresholdOperator)
    {
        $this->objectThresholdOperator = $objectThresholdOperator;
        return $this;
    }

    /**
     * @param mixed $objectTimeWindow
     * @return ObjectBuilder builder object
     */
    function objectTimeWindow($objectTimeWindow)
    {
        $this->objectTimeWindow = $objectTimeWindow;
        return $this;
    }

    /**
     * @param mixed $objectType
     * @return ObjectBuilder builder object
     */
    function objectType($objectType)
    {
        $this->objectType = $objectType;
        return $this;
    }

    /**
     * @return mixed
     */
    function getCreatedBy()
    {
        return $this->createdBy;
    }

    /**
     * @return mixed
     */
    function getCreatedDate()
    {
        return $this->createdDate;
    }

    /**
     * @return mixed
     */
    function getModifiedBy()
    {
        return $this->modifiedBy;
    }

    /**
     * @return mixed
     */
    function getModifiedDate()
    {
        return $this->modifiedDate;
    }

    /**
     * @return mixed
     */
    function getObjectDescription()
    {
        return $this->objectDescription;
    }

    /**
     * @return mixed
     */
    function getObjectId()
    {
        return $this->objectId;
    }

    /**
     * @return mixed
     */
    function getObjectLabel()
    {
        return $this->objectLabel;
    }

    /**
     * @return mixed
     */
    function getObjectLogFiles()
    {
        return $this->objectLogFiles;
    }

    /**
     * @return mixed
     */
    function getObjectOperator()
    {
        return $this->objectOperator;
    }

    /**
     * @return mixed
     */
    function getObjectString()
    {
        return $this->objectString;
    }

    /**
     * @return mixed
     */
    function getObjectThreshold()
    {
        return $this->objectThreshold;
    }

    /**
     * @return mixed
     */
    function getObjectThresholdOperator()
    {
        return $this->objectThresholdOperator;
    }

    /**
     * @return mixed
     */
    function getObjectTimeWindow()
    {
        return $this->objectTimeWindow;
    }

    /**
     * @return mixed
     */
    function getObjectType()
    {
        return $this->objectType;
    }

    function build() {
        return new Object($this);
    }
}

?>