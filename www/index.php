<?php
require_once("vendor/autoload.php");
require_once("GarminConnectExtended.php");

$garminClient = new GarminConnectExtended(['username' => 'j.somhorst@gmail.com','password'=> 'upspA4zyf6HjdufLYVk9GVLhvsG8hsgK']);
$garminClient->getActivityList();

if(array_key_exists('type',$_GET) && $_GET['type'] == 'mysegments') {
    if(array_key_exists('id',$_GET)){
        echo print_r($garminClient->getSegment($_GET['id'],true));
    }else{
        echo print_r($garminClient->getMySegments(), true);
    }
}
$start = 0;
$pageSize = 10;
$page = 1;
$result = $garminClient->getActivityList($start,$pageSize,null,'startLocal','desc');
$activities = array();
error_log("Start retrieving activities");

$activities = array_merge($activities,$result);

foreach($activities as $activity){
    $gpx = $garminClient->getDataFile("gpx",$activity->activityId);
    $filename = sprintf("%s.gpx",$activity->activityId);
    $gpxhandle = fopen($filename,"w");
    if($gpxhandle === false){
        error_log(sprintf("Cant write to file %s",$filename));
    }else{
        fwrite($gpxhandle,$gpx);
        fclose($gpxhandle);
    }
}


