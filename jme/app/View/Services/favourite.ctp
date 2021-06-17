<?php 

$flg = true;
$flag = false;
$arr = '';
$arrFavourite = array();
$arrVideoLang = array();

$is_voted = 0;
$is_favourite = 0;
$categories = '';
$title = '';
$description = '';

if(!empty($video)){
	
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
	foreach($video['VideoCategory'] as $video_cat){
		if($video_cat['Category']['status'] == 0){
			foreach($video_cat['Category']['CategoryLanguage'] as $cat){
				if($cat['language_id'] == $language_id){	
					if($flg){
						$categories = $cat['name'];
						$flg = false;
					}else{
						$categories .= ', '.$cat['name'];
					}
				}
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
	
	// Resulted array
	$arr = array(
				'id' => $video['Video']['id'],
				//'is_favourite' => $is_favourite,
				'is_voted' => $is_voted,
				'title' => $title,
				'description' => $description,
				'director' => html_entity_decode($video['Video']['director'], ENT_QUOTES),
				'categories' => $categories,
				'votes' => count($video['Vote']),
				'views' => $video['Video']['video_views'],
				'duration' => $video['Video']['video_duration'],
				'thumbnail' => $video['Video']['video_thumbnail'],
				'url' => $video['Video']['video_url'],
				'dateAdded' => $video['Video']['created'],
			);
}

if(!empty($video) && count($video) > 0){
	$flag = true;
}

// Check whether $flag is true or false
if($flag){
	// Store the value in array
	$arrFavourite = array('error'=>'0','errorMessage'=>'success','video'=>$arr);
}else{
	$arrFavourite = array('error'=>'1','errorMessage'=>'error','video'=>$arr);
}

// Json encode the array and print the same
echo json_encode($arrFavourite);
exit;

?>
