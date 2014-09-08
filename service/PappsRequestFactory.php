<?php
/**
 * Created by PhpStorm.
 * User: zarina
 * Date: 9/3/14
 * Time: 8:49 PM
 */

class PappsRequestFactory {

    public function initialize($inputFile) {

        if(!file_exists($inputFile)) {
            die("File: $inputFile doesn't exist");
        }
        // input xml file data
        $data = simplexml_load_file($inputFile);

        $pappsRequestBuilder = PappsRequest::createBuilder()
            ->requestId((string)$data->request_id)->requestLabel((string)$data->request_label)
            ->caseId((string)$data->case_id)->tsPath((string)$data->ts_file)
            ->xmlRequest((string)$data->xml_request)->xmlResult((string)$data->xml_result)
            ->userName((string)$data->username)
            ->startTime((string)$data->request_timerange_start)->endTime((string)$data->request_timerange_end)
            ->requestStartTime((string)$data->request_time)->requestCompleteTime((string)$data->complete_time)
            ->requestTestToggle((string)$data->request_test_toggle);

        $this->loadProfiles($data, $pappsRequestBuilder);
        //$this->extractArchiveFile($content);
        return $pappsRequestBuilder->build();
    }

    protected function loadProfiles($data, $pappsRequestBuilder){
        $profiles = array();
        foreach($data->children() as $child) {
            if(preg_match("/^profile_id.*/", $child->getName())) {
                $profileTag = $child->getName();
                $profile = $data->$profileTag;

                $profileBuilder = Profile::createBuilder()
                    ->profileId((string)$profile->profile_id)->profileLabel((string)$profile->profile_label)->profileDescription((string)$profile->profile_description)
                    ->createdBy((string)$profile->profile_created_by)->createdDate((string)$profile->profile_create_date)
                    ->modifiedBy((string)$profile->profile_modified_by)->modifiedDate((string)$profile->profile_modified_date)
                    ->profileSeverity((string)$profile->profile_severity)->profileStatus((string)$profile->profile_status);

                $this->loadObjects($profile, $profileBuilder);
                array_push($profiles, $profileBuilder->build());
            }
        }
        $pappsRequestBuilder->profiles($profiles);
    }


    protected function loadObjects($profile, $profileBuilder){
        $objects = array();
        foreach($profile->children() as $child) {
            $objectTag = $child->getName();
            if(preg_match("/^object_id.*/", $objectTag)) {
                $object = $profile->$objectTag;
                $objectBuilder = Object::createBuilder()
                    ->objectId((string)$object->object_id)->objectLabel((string)$object->object_label)->objectType((string)$object->object_type)
                    ->objectString((string)$object->object_string)->logicalOperator((string)$object->logical_operator)->objectLogFiles((string)$object->object_log_files)
                    ->objectDescription((string)$object->object_description)->objectThreshold((string)$object->object_treshold)->objectThresholdOperator((string)$object->object_treshold_operator)
                    ->objectTimeWindow((string)$object->object_time_window)
                    ->createdBy((string)$object->object_created_by)->createdDate((string)$object->object_create_date)
                    ->modifiedBy((string)$object->object_modified_by)->modifiedDate((string)$object->object_modified_date);

                array_push($objects, $objectBuilder->build());
            }
        }
        $profileBuilder->objects($objects);
    }

}

?>