<?php

class PappsRequest {
	
	public $requestId;
	public $requestLabel;
	public $caseId;
	public $tsPath;
	public $userName;
	public $xmlRequest;
	public $xmlResult;
	public $startTime;
	public $endTime;
    public $requestStartTime;
	public $requestCompleteTime;
	public $requestTestToggle;
	public $profiles;

    static function createBuilder() {
        return new PappsRequestBuilder();
    }

    public function __construct(PappsRequestBuilder $builder) {

        $this->requestId = $builder->getRequestId();
        $this->requestLabel = $builder->getRequestLabel();
        $this->caseId = $builder->getCaseId();
        $this->tsPath = $builder->getTsPath();
        $this->userName = $builder->getUserName();
        $this->xmlRequest = $builder->getXmlRequest();
        $this->xmlResult = $builder->getXmlResult();
        $this->startTime = $builder->getStartTime();
        $this->endTime = $builder->getEndTime();
        $this->requestStartTime = $builder->getRequestStartTime();
        $this->requestCompleteTime = $builder->getRequestCompleteTime();
        $this->requestTestToggle = $builder->getRequestTestToggle();
        $this->profiles = $builder->getProfiles();

    }

}

?>