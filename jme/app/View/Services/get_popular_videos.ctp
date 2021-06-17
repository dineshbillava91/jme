<?php 

	$flag = false;
	$arr = array();
	$arrGetPopularVideosList = array();
	$videoCount = count($videoLanguages);
	if(!empty($videoLanguages)){
		foreach($videoLanguages as $videoLanguage){
			$flg = true;
			$is_voted = 0;
			$is_favourite = 0;
			$title = '';
			$categories = '';
			$description = '';
			$arrVideoLang = array();
			
			// Vote
			foreach($videoLanguage['Video']['Vote'] as $vot){
				if($vot['device'] == $device_id){
					$is_voted = 1;
					break;
				}
			}
		
			// Favourite
			foreach($videoLanguage['Video']['Favourite'] as $fav){
				if($fav['device'] == $device_id){
					$is_favourite = 1;
					break;
				}
			}
			
			// Categories
			/* foreach($videoLanguage['Video']['VideoCategory'] as $cat){
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
			} */
			foreach($videoLanguage['Video']['VideoCategory'] as $cat){
				
				if($flg){
					if($cat['status'] == 0){
						$categories = $cat['Category']['name'];
						$flg = false;
					}
				}else{
					if($cat['status'] == 0){
						$categories .= ', '.$cat['Category']['name'];
					}
				}
			}
			
			// title and description based on language_id
			foreach($videoLanguage['Video']['VideoLanguage'] as $res){
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
			
			
			
			
			
			$series_name = ($videoLanguage['Video']['VideoTvseries'][0]['Tvseries']['title_english'])?$videoLanguage['Video']['VideoTvseries'][0]['Tvseries']['title_english']:"";
		
			if($language_id == 'es'){
				
			$series_name = html_entity_decode($videoLanguage['Video']['VideoTvseries'][0]['Tvseries']['title_spanish'],ENT_QUOTES, 'UTF-8');
				
			}else if($language_id == 'fr'){
				
			$series_name = html_entity_decode($videoLanguage['Video']['VideoTvseries'][0]['Tvseries']['title_french'],ENT_QUOTES, 'UTF-8');
				
			}else{
				
			$series_name = html_entity_decode($videoLanguage['Video']['VideoTvseries'][0]['Tvseries']['title_english'],ENT_QUOTES, 'UTF-8');
				
			}
			
			// Resulted array
			$arr[] = array(
						'id' => $videoLanguage['Video']['id'],
						//'is_favourite' => $is_favourite,
						'is_voted' => $is_voted,
						'title' => $title,
						'description' => $description,
						'director' => html_entity_decode($videoLanguage['Video']['director'], ENT_QUOTES),
						'categories' => $categories,
						'series_name' => $series_name,
						'votes' => count($videoLanguage['Video']['Vote']),
						'views' => $videoLanguage['Video']['video_views'],
						'duration' => $videoLanguage['Video']['video_duration'],
						'thumbnail' => $videoLanguage['Video']['video_thumbnail'],
						'url' => $videoLanguage['Video']['video_url'],
						'dateAdded' => $videoLanguage['Video']['created'],
						'status' => $videoLanguage['Video']['status']
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
