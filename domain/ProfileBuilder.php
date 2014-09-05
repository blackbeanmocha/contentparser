<?php
/**
 * Created by PhpStorm.
 * User: zarina
 * Date: 9/3/14
 * Time: 10:58 PM
 */ 
   
class ProfileBuilder {
    
    private $profileId;
    private $profileLabel;
    private $profileDescription;
    private $createdBy;
    private $createdDate;
    private $modifiedBy;
    private $modifiedDate;
    private $profileSeverity;
    private $profileStatus;
    private $objects;

    function __construct() {
    }

    /**
     * @param mixed $createdBy
     * @return ProfileBuilder builder object
     */
    function createdBy($createdBy)
    {
        $this->createdBy = $createdBy;
        return $this;
    }

    /**
     * @param mixed $createdDate
     * @return ProfileBuilder builder object
     */
    function createdDate($createdDate)
    {
        $this->createdDate = $createdDate;
        return $this;
    }

    /**
     * @param mixed $modifiedBy
     * @return ProfileBuilder builder object
     */
    function modifiedBy($modifiedBy)
    {
        $this->modifiedBy = $modifiedBy;
        return $this;
    }

    /**
     * @param mixed $modifiedDate
     * @return ProfileBuilder builder object
     */
    function modifiedDate($modifiedDate)
    {
        $this->modifiedDate = $modifiedDate;
        return $this;
    }

    /**
     * @param mixed $objects
     * @return ProfileBuilder builder object
     */
    function objects($objects)
    {
        $this->objects = $objects;
        return $this;
    }

    /**
     * @param mixed $profileDescription
     * @return ProfileBuilder builder object
     */
    function profileDescription($profileDescription)
    {
        $this->profileDescription = $profileDescription;
        return $this;
    }

    /**
     * @param mixed $profileId
     * @return ProfileBuilder builder object
     */
    function profileId($profileId)
    {
        $this->profileId = $profileId;
        return $this;
    }

    /**
     * @param mixed $profileLabel
     * @return ProfileBuilder builder object
     */
    function profileLabel($profileLabel)
    {
        $this->profileLabel = $profileLabel;
        return $this;
    }

    /**
     * @param mixed $profileSeverity
     * @return ProfileBuilder builder object
     */
    function profileSeverity($profileSeverity)
    {
        $this->profileSeverity = $profileSeverity;
        return $this;
    }

    /**
     * @param mixed $profileStatus
     * @return ProfileBuilder builder object
     */
    function profileStatus($profileStatus)
    {
        $this->profileStatus = $profileStatus;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getCreatedBy()
    {
        return $this->createdBy;
    }

    /**
     * @return mixed
     */
    public function getCreatedDate()
    {
        return $this->createdDate;
    }

    /**
     * @return mixed
     */
    public function getModifiedBy()
    {
        return $this->modifiedBy;
    }

    /**
     * @return mixed
     */
    public function getModifiedDate()
    {
        return $this->modifiedDate;
    }

    /**
     * @return mixed
     */
    public function getObjects()
    {
        return $this->objects;
    }

    /**
     * @return mixed
     */
    public function getProfileDescription()
    {
        return $this->profileDescription;
    }

    /**
     * @return mixed
     */
    public function getProfileId()
    {
        return $this->profileId;
    }

    /**
     * @return mixed
     */
    public function getProfileLabel()
    {
        return $this->profileLabel;
    }

    /**
     * @return mixed
     */
    public function getProfileSeverity()
    {
        return $this->profileSeverity;
    }

    /**
     * @return mixed
     */
    public function getProfileStatus()
    {
        return $this->profileStatus;
    }

    function build() {
        return new Profile($this);
    }
}

?>