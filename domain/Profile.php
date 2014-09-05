<?php
/**
 * Created by PhpStorm.
 * User: zarina
 * Date: 9/3/14
 * Time: 10:58 PM
 */ 
    
class Profile {

    public $profileId;
    public $profileLabel;
    public $profileDescription;
    public $createdBy;
    public $createdDate;
    public $modifiedBy;
    public $modifiedDate;
    public $profileSeverity;
    public $profileStatus;
    public $objects;

    static function createBuilder() {
        return new ProfileBuilder();
    }

    public function __construct(ProfileBuilder $builder) {
        $this->profileId = $builder->getProfileId();
        $this->profileLabel = $builder->getProfileLabel();
        $this->profileDescription = $builder->getProfileDescription();
        $this->createdBy = $builder->getCreatedBy();
        $this->createdDate = $builder->getCreatedDate();
        $this->modifiedBy = $builder->getModifiedBy();
        $this->modifiedDate = $builder->getModifiedDate();
        $this->profileSeverity = $builder->getProfileSeverity();
        $this->profileStatus = $builder->getProfileStatus();
        $this->objects = $builder->getObjects();
    }
}
?>