<?php
include_once('dbClass.php');
include_once('library/constants.php');

$sqlGetVideoIds=mysql_query("select id,youtube from videos");
//$i=0;
while($row=mysql_fetch_assoc($sqlGetVideoIds)){
        //The Youtube's API url
        $url = 'http://gdata.youtube.com/feeds/api/videos/'.$row['youtube'].'?v=2&prettyprint=true&alt=json';

        //Using cURL php extension to make the request to youtube API
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

        //$feed holds json returned by youtube API
        $feed = curl_exec($ch);
        $info = curl_getinfo($ch);
        curl_close($ch);
        // Decode JSON data 
        $arrJSON = json_decode($feed, true);
        if($info['http_code']==200){
                $updateQuery=mysql_query("Update videos set views=".$arrJSON['entry']['yt$statistics']['viewCount']." WHERE id=".$row['id']);
                echo "Video with id : ".$row['id']." is updated<br/>";
        }else{
                echo $info['http_code']." Error occur while inserting video with id : ".$row['id']." Error : ".$feed."<br/>";
        }
        //$i++;if($i==4){die;}

