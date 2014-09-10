<?php

date_default_timezone_set('America/Los_Angeles');

/**
 * Created by PhpStorm.
 * User: zarina
 * Date: 9/3/14
 * Time: 8:29 PM
 */

class PappsRequestBuilder {

    /**
     * @var
     */
    private $requestId;
    private $requestLabel;
    private $caseId;
    private $tsPath;
    private $userName;
    private $xmlRequest;
    private $xmlResult;
    private $startTime;
    private $endTime;
    private $requestStartTime;
    private $requestCompleteTime;
    private $requestTestToggle;
    private $profiles;


    function __construct() {
    }

    /**
     * @param mixed $caseId
     * @return PappsRequestBuilder builder object
     */
    function caseId($caseId)
    {
        $this->caseId = $caseId;
        return $this;
    }

    /**
     * @param mixed $startTime
     * @return PappsRequestBuilder builder object
     */
    function requestStartTime($startTime)
    {
        $this->requestStartTime = $startTime;
        return $this;
    }

    /**
     * @param mixed $completeTime
     * @return PappsRequestBuilder builder object
     */
    function requestCompleteTime($completeTime)
    {
        $this->requestCompleteTime = $completeTime;
        return $this;
    }

    /**
     * @param mixed $endTime
     * @return PappsRequestBuilder builder object
     */
    function endTime($endTime)
    {
        //$this->endTime = date("M d H:i:s", strtotime($endTime));
        $this->endTime = $endTime;
        return $this;
    }

    /**
     * @param mixed $profiles
     * @return PappsRequestBuilder builder object
     */
    function profiles($profiles)
    {
        $this->profiles = $profiles;
        return $this;
    }

    /**
     * @param mixed $requestId
     * @return PappsRequestBuilder builder object
     */
    function requestId($requestId)
    {
        $this->requestId = $requestId;
        return $this;
    }

    /**
     * @param mixed $requestLabel
     * @return PappsRequestBuilder builder object
     */
    function requestLabel($requestLabel)
    {
        $this->requestLabel = $requestLabel;
        return $this;
    }

    /**
     * @param mixed $requestTestToggle
     * @return PappsRequestBuilder builder object
     */
    function requestTestToggle($requestTestToggle)
    {
        $this->requestTestToggle = $requestTestToggle;
        return $this;
    }

    /**
     * @param mixed $startTime
     * @return PappsRequestBuilder builder object
     */
    function startTime($startTime)
    {
        //$this->startTime = date("M d H:i:s", strtotime($startTime));
        $this->startTime = $startTime;
        return $this;
    }

    /**
     * @param mixed $tsPath
     * @return PappsRequestBuilder builder object
     */
    function tsPath($tsPath)
    {
        $this->tsPath = $tsPath;
        return $this;
    }

    /**
     * @param mixed $userName
     * @return PappsRequestBuilder builder object
     */
    function userName($userName)
    {
        $this->userName = $userName;
        return $this;
    }

    /**
     * @param mixed $xmlRequest
     * @return PappsRequestBuilder builder object
     */
    function xmlRequest($xmlRequest)
    {
        $this->xmlRequest = $xmlRequest;
        return $this;
    }

    /**
     * @param mixed $xmlResult
     * @return PappsRequestBuilder builder object
     */
    function xmlResult($xmlResult)
    {
        $this->xmlResult = $xmlResult;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getCaseId()
    {
        return $this->caseId;
    }

    /**
     * @return mixed
     */
    public function getEndTime()
    {
        return $this->endTime;
    }

    /**
     * @return mixed
     */
    public function getProfiles()
    {
        return $this->profiles;
    }

    /**
     * @return mixed
     */
    public function getRequestId()
    {
        return $this->requestId;
    }

    /**
     * @return mixed
     */
    public function getRequestLabel()
    {
        return $this->requestLabel;
    }

    /**
     * @return mixed
     */
    public function getRequestTestToggle()
    {
        return $this->requestTestToggle;
    }

    /**
     * @return mixed
     */
    public function getStartTime()
    {
        return $this->startTime;
    }

    /**
     * @return mixed
     */
    public function getTsPath()
    {
        return $this->tsPath;
    }


    /**
     * @return mixed
     */
    public function getUserName()
    {
        return $this->userName;
    }

    /**
     * @return mixed
     */
    public function getXmlRequest()
    {
        return $this->xmlRequest;
    }

    /**
     * @return mixed
     */
    public function getXmlResult()
    {
        return $this->xmlResult;
    }

    /**
     * @return mixed
     */
    public function getRequestCompleteTime()
    {
        return $this->requestCompleteTime;
    }

    /**
     * @return mixed
     */
    public function getRequestStartTime()
    {
        return $this->requestStartTime;
    }

    function build() {
        return new PappsRequest($this);
    }

}

?>