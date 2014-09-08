<?php

class Object{

    public $objectId;
    public $objectLabel;
    public $objectType;
    public $objectString;
    public $logicalOperator;
    public $objectLogFiles;
    public $objectDescription;
    public $objectThreshold;
    public $objectThresholdOperator;
    public $objectTimeWindow;
    public $createdBy;
    public $createdDate;
    public $modifiedBy;
    public $modifiedDate;

    static function createBuilder() {
        return new ObjectBuilder();
    }

    public function __construct(ObjectBuilder $builder) {
        
        $this->objectId = $builder->getObjectId();
        $this->objectLabel = $builder->getObjectLabel();
        $this->objectType = $builder->getObjectType();
        $this->objectString = $builder->getObjectString();
        $this->logicalOperator = $builder->getLogicalOperator();
        $this->objectLogFiles = $builder->getObjectLogFiles();
        $this->objectDescription = $builder->getObjectDescription();
        $this->objectThreshold = $builder->getObjectThreshold();
        $this->objectThresholdOperator = $builder->getObjectThresholdOperator();
        $this->objectTimeWindow = $builder->getObjectTimeWindow();
        $this->createdBy = $builder->getCreatedBy();
        $this->createdDate = $builder->getCreatedDate();
        $this->modifiedBy = $builder->getModifiedBy();
        $this->modifiedDate = $builder->getModifiedDate();
        
    }
}

?>