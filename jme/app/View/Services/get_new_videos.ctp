<?php 

	$flag = false;
	$arr = array();
	$arrGetPopularVideosList = array();
	$videoCount = count($videos);
	if(!empty($videos)){
		foreach($videos as $video){
			
			$flg = true;
			$is_voted = 0;
			$is_favourite = 0;
			$title = '';
			$categories = '';
			$description = '';
			$arrVideoLang = array();
			
			// Vote
			foreach($video['Vote'] as $vot){
				if($vot['device'] == $device_id){
					$is_voted = 1;
					break;
				}
			}
			
			// Favourite
			foreach($video['Favourite'] as $fav){
				if($fav['device'] == $device_id){
					$is_favourite = 1;
					break;
				}
			}
			
			// Categories
			foreach($video['VideoCategory'] as $cat){
				if($flg){
					if($cat['Category']['status'] == 0){
						$categories = $cat['Category']['name'];
						$flg = false;
					}
				}else{
					if($cat['Category']['status'] == 0){
						$categories .= ', '.$cat['Category']['name'];
					}
				}
			}
			
			// title and description based on language_id
			foreach($video['VideoLanguage'] as $res){
				$arrVideoLang[$res['language_id']] = array('title'=>$res['title'],'description'=>$res['description']);
			}
			if (array_key_exists($language_id, $arrVideoLang)) {
				if(!empty($arrVideoLang[$language_id]['title'])){
					$title = html_entity_decode($arrVideoLang[$language_id]['title'], ENT_QUOTES, 'UTF-8');
				}else{
					$title = html_entity_decode($arrVideoLang['en']['title'], ENT_QUOTES, 'UTF-8');
				}
				
				if(!empty($arrVideoLang[$language_id]['description'])){
					$description = html_entity_decode($arrVideoLang[$language_id]['description'], ENT_QUOTES, 'UTF-8');
				}else{
					$description = html_entity_decode($arrVideoLang['en']['description'], ENT_QUOTES, 'UTF-8');
				}
			}else{
				$title = html_entity_decode($arrVideoLang['en']['title'], ENT_QUOTES);
				$description = html_entity_decode($arrVideoLang['en']['description'], ENT_QUOTES);
			}
			
			
			$series_name = ($video['VideoTvseries'][0]['Tvseries']['title_english'])?$video['VideoTvseries'][0]['Tvseries']['title_english']:"";
		
			if($language_id == 'es'){
				
			$series_name = html_entity_decode($video['VideoTvseries'][0]['Tvseries']['title_spanish'],ENT_QUOTES, 'UTF-8');
				
			}else if($language_id == 'fr'){
				
			$series_name = html_entity_decode($video['VideoTvseries'][0]['Tvseries']['title_french'],ENT_QUOTES, 'UTF-8');
				
			}else{
				
			$series_name = html_entity_decode($video['VideoTvseries'][0]['Tvseries']['title_english'],ENT_QUOTES, 'UTF-8');
				
			}
			
			
			
			// Resulted array
			$arr[] = array(
						'id' => $video['Video']['id'],
						//'is_favourite' => $is_favourite,
						'is_voted' => $is_voted,
						'title' => html_entity_decode($title,ENT_QUOTES,'UTF-8'),
						'description' =>html_entity_decode($description,ENT_QUOTES,'UTF-8'), 
						'director' => html_entity_decode($video['Video']['director'], ENT_QUOTES),
						'categories' => $categories,
						'series_name' => $series_name,
						'votes' => count($video['Vote']),
						'views' => $video['Video']['video_views'],
						'duration' => $video['Video']['video_duration'],
						'thumbnail' => $video['Video']['video_thumbnail'],
						'url' => $video['Video']['video_url'],
						'dateAdded' => $video['Video']['created'],
						'status' => $video['Video']['status']
					);
					
					
		}
	}

	if($videoCount > 0 || $videoCount == 0){
		$flag = true;
	}
	
	if($flag){
		$arrGetPopularVideosList = array('error'=>'0','errorMessage'=>'success','videoCount'=>$videoCount,'videoList'=>$arr);
	}else{
		$arrGetPopularVideosList = array('error'=>'1','errorMessage'=>'error','videoCount'=>0,'videoList'=>$arr);
	}
	
	echo json_encode($arrGetPopularVideosList);
	exit;
	
?>
