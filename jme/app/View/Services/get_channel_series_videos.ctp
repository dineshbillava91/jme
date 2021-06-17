<?php 

	$flag = false;
	$arr = array();
	//$tvseriesCount = count($tvseries[0]['VideoTvseries']);


	$tvseriesCount = 0;
	if(!empty($tvseries)){
		foreach($tvseries as $tvseriesRelate){
			
			$flg = true;
			$title = '';
			foreach($tvseriesRelate['VideoTvseries'] as $singleVideoDetails){
				
				//CHECK: only non deleted videos are added in the response array.
				if($singleVideoDetails['Videos']['status'] == '0' && in_array($singleVideoDetails['Videos']['id'],$vids)){
					
					$tvseriesCount++;
					
					$title = $singleVideoDetails['Videos']['VideoLanguage'][0]['title'];
					$description = $singleVideoDetails['Videos']['VideoLanguage'][0]['description'];
					$series_name = $tvseriesRelate['Tvseries']['title_english'];
					
					if($language_id == 'es'){
						
					$title = $singleVideoDetails['Videos']['VideoLanguage'][2]['title'];
					$description = $singleVideoDetails['Videos']['VideoLanguage'][2]['description'];
					$series_name = $tvseriesRelate['Tvseries']['title_spanish'];
						
					}else if($language_id == 'fr'){
						
					$title = $singleVideoDetails['Videos']['VideoLanguage'][1]['title'];
					$description = $singleVideoDetails['Videos']['VideoLanguage'][1]['description'];
					$series_name = $tvseriesRelate['Tvseries']['title_french'];
						
					}
					
				
					if(empty($singleVideoDetails['votes'])){ $singleVideoDetails['votes'] = "0"; }
					
					$is_voted = 0;
					
					// print_r($singleVideoDetails['Vote']);
					
					// Vote
					if($singleVideoDetails['Vote']['device'] == $device_id){ $is_voted = 1;}
					
					
					// Resulted array
					$arr[] = array(
						'id' => $singleVideoDetails['Videos']['id'],
						'title' => html_entity_decode($title,ENT_QUOTES,'UTF-8'),
						'description' => html_entity_decode($description,ENT_QUOTES,'UTF-8'),
						'votes' => $singleVideoDetails['votes'],
						'is_voted' => $is_voted,
						'categories' => $singleVideoDetails['categories'],
						'series_name' => html_entity_decode($series_name,ENT_QUOTES,'UTF-8'),
						'views' => $singleVideoDetails['Videos']['video_views'],
						'duration' => $singleVideoDetails['Videos']['video_duration'],
						'thumbnail' => $singleVideoDetails['Videos']['video_thumbnail'],
						'url' => $singleVideoDetails['Videos']['video_url'],
						'dateAdded' => $singleVideoDetails['Videos']['created'],
						'director' => $singleVideoDetails['Videos']['director'],
						'status' => $singleVideoDetails['Videos']['status']
					); 
				}	
			}
		}
	}
	
	if($tvseriesCount > 0 || $tvseriesCount == 0){
		$flag = true;
	}
	
	if($flag){
		$arrGetRelatedSeriesList = array('error'=>'0','errorMessage'=>'success','videoCount'=>$tvseriesCount,'videoList'=>$arr);
	}else{
		$arrGetRelatedSeriesList = array('error'=>'1','errorMessage'=>'error','videoCount'=>0,'videoList'=>$arr);
	}

	/* echo '<pre>';
	print_r($arrGetRelatedSeriesList);
	exit;  */

	
	echo json_encode($arrGetRelatedSeriesList);
	exit;
	
?>
