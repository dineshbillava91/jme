<?php 

	$flag = false;
	$arr = array();
	$videoCount = count($videoRelates);
	if(!empty($videoRelates)){
		foreach($videoRelates as $videoRelate){
		
			$flg = true;
			$title = '';
			$is_voted = 0;
			$categories = '';
			$description = '';
			$is_favourite = 0;
			$arrVideoLang = array();
			
			// Vote
			if(!empty($videoRelate['Vote'])){
				foreach($videoRelate['Vote'] as $vot){
					if($vot['device'] == $device_id){
						$is_voted = 1;
						break;
					}
				}
			}
			
			// Favourite
			if(!empty($videoRelate['Favourite'])){
				foreach($videoRelate['Favourite'] as $fav){
					if($fav['device'] == $device_id){
						$is_favourite = 1;
						break;
					}
				}
			}
			
			// Categories
			if(!empty($videoRelate['VideoCategory'])){
				foreach($videoRelate['VideoCategory'] as $cat){
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
			}
			
			// title and description based on language_id
			if(!empty($videoRelate['VideoLanguage'])){
				foreach($videoRelate['VideoLanguage'] as $res){
					$arrVideoLang[$res['language_id']] = array('title'=>$res['title'],'description'=>$res['description']);
				}
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
			
			$series_name = ($videoRelate['VideoTvseries'][0]['series_name'])?$videoRelate['VideoTvseries'][0]['series_name']:"";
			
			// Resulted array
			$arr[] = array(
						'id' => $videoRelate['Video']['id'],
						//'is_favourite' => $is_favourite,
						'is_voted' => $is_voted,
						'title' => $title,
						'description' => $description,
						'director' => html_entity_decode($videoRelate['Video']['director'], ENT_QUOTES),
						'categories' => $categories,
						'series_name' => $series_name,
						'votes' => count($videoRelate['Vote']),
						'views' => $videoRelate['Video']['video_views'],
						'duration' => $videoRelate['Video']['video_duration'],
						'thumbnail' => $videoRelate['Video']['video_thumbnail'],
						'url' => $videoRelate['Video']['video_url'],
						'dateAdded' => $videoRelate['Video']['created'],
						'status' => $videoRelate['Video']['status']
					);
		}
	}

	if($videoCount > 0 || $videoCount == 0){
		$flag = true;
	}
	
	if($flag){
		$arrGetRelatedVideosList = array('error'=>'0','errorMessage'=>'success','videoCount'=>$videoCount,'videoList'=>$arr);
	}else{
		$arrGetRelatedVideosList = array('error'=>'1','errorMessage'=>'error','videoCount'=>0,'videoList'=>$arr);
	}
	
	echo json_encode($arrGetRelatedVideosList);
	exit;
	
?>
