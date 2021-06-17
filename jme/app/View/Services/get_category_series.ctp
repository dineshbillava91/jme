<?php 

	$flag = false;
	$arr = array();
	$videoCount = count($videoCategories);
	
	if(!empty($videoCategories)){
		$arr2=array();
		foreach($videoCategories as $videoCategory){
			
			$videoCategory = $videoCategory['Video']['VideoTvseries'];
			
			foreach($videoCategory as $video){
				
				$title =  $video['Tvseries']['title_english'];
				
				if($language_id == 'es'){
					
				$title = $video['Tvseries']['title_spanish'];		
				
				}else if($language_id == 'fr'){
					
				$title = $video['Tvseries']['title_french'];
					
				}
				
				// $a[] = $video['series_name'];
				// Resulted array
				$arr[] = array(
					'id' => $video['tvseries_id'],
					'title' => $title,
					// 'dateAdded' => $tvseriesRelate['Tvseries']['created']
				);
				$arr2 = array_merge($arr2,$arr);
			}
		}

		// Unique Array for return  
		$arrayRewrite = array();  
		// Array with the md5 hashes  
		$arrayHashes = array();  
		foreach($arr2 as $key => $item) {  
			// Serialize the current element and create a md5 hash  
			$hash = md5(serialize($item));  
			// If the md5 didn't come up yet, add the element to  
			// to arrayRewrite, otherwise drop it  
			if (!isset($arrayHashes[$hash])) {  
				// Save the current element hash  
				$arrayHashes[$hash] = $hash;  
				// Add element to the unique Array  
				if ($preserveKeys) {  
					$arrayRewrite[$key] = $item;  
				} else {  
					$arrayRewrite[] = $item;  
				}  
			}  
		}  
		$arr = $arrayRewrite;
	}
	
/* 	if(!empty($videoCategories)){
		foreach($videoCategories as $videoCategory){
		
			$flg = true;
			$is_voted = 0;
			$is_favourite = 0;
			$title = '';
			$description = '';
			$categories = '';
			$arrVideoLang = array();
		
			// Vote
			foreach($videoCategory['Video']['Vote'] as $vot){
				if($vot['device'] == $device_id){
					$is_voted = 1;
					break;
				}
			}
			
			// Favourite
			foreach($videoCategory['Video']['Favourite'] as $fav){
				if($fav['device'] == $device_id){
					$is_favourite = 1;
					break;
				}
			}
		
			// Categories
			if(!empty($videoCategory['Video']['VideoCategory'])){
				foreach($videoCategory['Video']['VideoCategory'] as $cat){
					if($flg){
						if($cat['status'] == 0){
							$categories = $cat['category_name'];
							$flg = false;
						}
					}else{
						if($cat['status'] == 0){
							$categories .= ', '.$cat['category_name'];
						}
					}
				}
			}
		
			// title and description based on language_id
			foreach($videoCategory['Video']['VideoLanguage'] as $res){
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
			
			$series_name = ($videoCategory['Video']['VideoTvseries'][0]['series_name'])?$videoCategory['Video']['VideoTvseries'][0]['series_name']:"";
			
			// Resulted array
			$arr[] = array(
						'id' => $videoCategory['Video']['id'],
						//'is_favourite' => $is_favourite,
						'is_voted' => $is_voted,
						'title' => $title,
						'description' => $description,
						'director' => html_entity_decode($videoCategory['Video']['director'], ENT_QUOTES),
						'categories' => $categories,
						'series_name' => $series_name,
						//'categories' => $videoCategory['CategoryLanguage'][0]['name'],
						'votes' => count($videoCategory['Video']['Vote']),
						'views' => $videoCategory['Video']['views'],
						'dateAdded' => $videoCategory['Video']['created'],
						'youtube' => $videoCategory['Video']['youtube'],
						'youtube_url' => $videoCategory['Video']['youtube_url'],
						'youtube_sqdefault' => $videoCategory['Video']['youtube_sqdefault'],
						'youtube_mqdefault' => $videoCategory['Video']['youtube_mqdefault'],
						'youtube_hqdefault' => $videoCategory['Video']['youtube_hqdefault'],
						'youtube_duration' => $videoCategory['Video']['youtube_duration']
					);
		}
	}

	if($videoCount > 0 || $videoCount == 0){
		$flag = true;
	}
	
	if($flag){
		$arrGetVideosListByCategory = array('error'=>'0','errorMessage'=>'success','videoCount'=>$videoCount,'videoList'=>$arr);
	}else{
		$arrGetVideosListByCategory = array('error'=>'1','errorMessage'=>'error','videoCount'=>0,'videoList'=>$arr);
	} */
	
	// eho json_encode($arrGetVideosListByCategory);
	
	$seriesCount = count($arr);
	if($seriesCount > 0 || $seriesCount == 0){
		$flag = true;
	}
	
	if($flag){
		$arrGetVideosListByCategory = array('error'=>'0','errorMessage'=>'success','seriesCount'=>$seriesCount,'seriesList'=>$arr);
	}else{
		$arrGetVideosListByCategory = array('error'=>'1','errorMessage'=>'error','videoCount'=>0,'videoList'=>$arr);
	}
	echo json_encode($arrGetVideosListByCategory);
	exit;
	
?>
