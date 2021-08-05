<?php

namespace App;

use dawguk\GarminConnect\exceptions\UnexpectedResponseCodeException;

class GarminConnectExtended extends \dawguk\GarminConnect
{
    //'activities','workouts','segments'


    const EXPORT_TYPE_ACTIVITIES = 'activities';
    const EXPORT_TYPE_SEGMENTS = 'segments';
    const EXPORT_TYPE_WORKOUTS = 'workouts';

    public function getMySegments(){
        return $this->getSegmentList();
    }

    public function getActivityList($intStart = 0, $intLimit = 10, $strActivityType = null,$sortBy = null, $sortOrder = null)
    {
        $arrParams = array(
            'start' => $intStart,
            'limit' => $intLimit
        );

        if(!is_null($sortBy) && !is_null($sortOrder)){
            $arrParams['sortOrder'] = $sortOrder;
            $arrParams['sortBy'] = $sortBy;
        }

        if (null !== $strActivityType) {
            $arrParams['activityType'] = $strActivityType;
        }

        $strResponse = $this->objConnector->get(
            'https://connect.garmin.com/modern/proxy/activitylist-service/activities/search/activities',
            $arrParams,
            true
        );

        if ($this->objConnector->getLastResponseCode() != 200) {
            throw new UnexpectedResponseCodeException($this->objConnector->getLastResponseCode());
        }
        $objResponse = json_decode($strResponse);
        return $objResponse;

    }

    public function getSegmentList(int $limit = 200, bool $mySegments = true, $location = null, bool $showFavorites = true){
        $strUrl = "https://connect.garmin.com/modern/proxy/course-service/segment/filterSegments";

        $headers = array(
            'NK: NT',
            'Content-Type: application/json'
        );

        $body = array();
        $body['limit'] = $limit;
        $body['mineOnly'] = $mySegments;
        $body['showFavorites'] = $showFavorites;

        if(!is_null($location)){
            $body['minLat'] = $location['minLat'];
            $body['minLon'] = $location['minLon'];
            $body['maxLat'] = $location['maxLat'];
            $body['maxLon'] = $location['maxLon'];
        }

        $strResponse = $this->objConnector->post($strUrl,[],[],true,$strUrl,$headers,json_encode($body));
        if($this->objConnector->getLastResponseCode() >= 300){
            throw new UnexpectedResponseCodeException($this->objConnector->getLastResponseCode());
        }
        return $strResponse;
    }

    public function updateSegments($activityId, $retryOnFailure = false,$retry = 0) : bool{

        $headers = array(
            'NK: NT',
            'Content-Type: application/json'
        );

        $strUrl = sprintf("https://connect.garmin.com/modern/proxy/activity-service/activity/segment/%s",$activityId);
        $body = ['activityId'=>$activityId];
        $strResponse = $this->objConnector->put($strUrl,
            [],
            [],
            true,
            $strUrl,
            $headers,
            json_encode($body));

        if ($this->objConnector->getLastResponseCode() != 204) {
            throw new UnexpectedResponseCodeException($this->objConnector->getLastResponseCode());
        }
        return true;
    }

    public function getSegment(mixed $id, bool $true)
    {
        $strUrl = sprintf("https://connect.garmin.com/modern/proxy/course-service/segment/%s",$id);
        $headers = array(
            'NK: NT',
            'Content-Type: application/json'
        );

        $strResponse = $this->objConnector->get($strUrl,[],true);
        if($this->objConnector->getLastResponseCode() >= 300){
            throw new UnexpectedResponseCodeException($this->objConnector->getLastResponseCode());
        }
        return $strResponse;

    }

}