<?php 

include_once('dbClass.php');
include_once('library/constants.php');
$j=0;
	do{
		//The Youtube's API url
		$start=(50*$j)+1;
		$url = YOUTUBE_URL.'?start-index='.$start.'&max-results=50&v=1&alt=json';
		
		//Using cURL php extension to make the request to youtube API
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

		
		$feed = curl_exec($ch);
		$info = curl_getinfo($ch);
		curl_close($ch);
		
		$arrJSON = json_decode($feed, true);
		
		//echo "<pre>";
		//print_r($arrJSON['feed']['entry']);die;
		$total=count($arrJSON['feed']['entry']);
		if($total > 0 && $info['http_code']==200)
		{
			for($i=0;$i< $total;$i++)
			{
				
				$desc=mysql_real_escape_string($arrJSON['feed']['entry'][$i]['content']['$t']);
				
				$title=mysql_real_escape_string($arrJSON['feed']['entry'][$i]['title']['$t']);
								
				$urlRes=explode('&',$arrJSON['feed']['entry'][$i]['link'][0]['href']);
				$url=$urlRes[0];
				
				$urlID=explode('=',$url);
				$url_id=$urlID[count($urlID)-1];
				
				$viewCount=$arrJSON['feed']['entry'][$i]['yt$statistics']['viewCount'];
				
				$duration = gmdate("H:i:s",$arrJSON['feed']['entry'][$i]['media$group']['yt$duration']['seconds']);
				
				$creat=$arrJSON['feed']['entry'][$i]['published']['$t'];
				$createdIn=strtotime($creat);
				//echo date('Y-m-d',$createdIn);
				
				$modified=$arrJSON['feed']['entry'][$i]['updated']['$t'];
				$modifiedIn=strtotime($modified);
						
				//print_r($arrJSON['feed']['entry']);die;
				//echo $url_id. "<br />";
				if($url!='' && $url_id!='')
				{
					//echo $url_id. "<br />";
					$sel=mysql_query('select id from videos where youtube_url="'.$url.'" or youtube="'.$url_id.'"');
					$rs=mysql_fetch_array($sel);
					if(mysql_num_rows($sel) > 0)
					{			
						$ID=$rs['id'];
						$update=mysql_query("update videos set views=$viewCount,modified=$modifiedIn where id=$ID");
						
						$update2=mysql_query("update video_languages set title='".$title."', description='".$desc."' where video_id=$ID and language_id='en'");
					
					}
					else
					{
						
						$url2 = 'http://gdata.youtube.com/feeds/api/videos/'.$url_id.'?v=2&prettyprint=true&alt=json';
						
						$ch = curl_init();
						curl_setopt($ch, CURLOPT_URL, $url2);
						curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
						$records = curl_exec($ch);
						curl_close($ch);
						$resJSON = json_decode($records, true);
						
						$youtube_sqdefault=$resJSON['entry']['media$group']['media$thumbnail'][0]['url'];
						$youtube_mqdefault=$resJSON['entry']['media$group']['media$thumbnail'][1]['url'];
						$youtube_hqdefault=$resJSON['entry']['media$group']['media$thumbnail'][2]['url'] ;
						
						
						$insert=mysql_query("insert into videos (youtube,youtube_url, youtube_sqdefault, youtube_mqdefault, youtube_hqdefault , youtube_duration, views ,created,modified)  values ('".$url_id."','".$url."','".$youtube_sqdefault."','".$youtube_mqdefault."','".$youtube_hqdefault."','".$duration."',".$viewCount.",".$createdIn.",".$modifiedIn.")");
						
						$insert_id=mysql_insert_id();
						
						$insert2=mysql_query("insert into video_languages (video_id,language_id , title , description) values (".$insert_id.",'en','".$title."','".$desc."')");	
					}
				}
			}
		}
				
		$j++;
	} 
	while($total > 0);
