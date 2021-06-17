<?php 

$arr = array();
$arrDevice = array();
$arrStaticField = array();
$arrLanguageStaticField = array();

// Check whether $flag is true or false
if($flag){
	// Store the value in array
	$arrDevice = array(
					'id'=>$device['Device']['id'], 
					'device'=>$device['Device']['device'], 
					'preferred_language'=>$device['Device']['preferred_language']
				);
	
	$arrStaticField = array(
						'tabbar_New' => $staticField['StaticField']['tabbar_New'],
						'tabbar_Channel' => $staticField['StaticField']['tabbar_Genre'],
						'tabbar_Popular' => $staticField['StaticField']['tabbar_Popular'],
						'tabbar_Favorites' => $staticField['StaticField']['tabbar_Favorites'],
						'tabbar_Languages' => $staticField['StaticField']['tabbar_Languages'],
						'change_Language' => $staticField['StaticField']['change_Language'],
						'select_a_Language' => $staticField['StaticField']['select_a_Language'],
						'videoDetail_Synopsis' => $staticField['StaticField']['videoDetail_Synopsis'],
						'videoDetail_Info' => $staticField['StaticField']['videoDetail_Info'],
						'videoDetail_AddToFav' => $staticField['StaticField']['videoDetail_AddToFav'],
						'videoDetail_AddVote' => $staticField['StaticField']['videoDetail_AddVote'],
						'videoDetail_RelatedVideos' => $staticField['StaticField']['videoDetail_RelatedVideos'],
						'videoDetail_Title' => $staticField['StaticField']['videoDetail_Title'],
						'videoDetail_Director' => $staticField['StaticField']['videoDetail_Director'],
						'videoDetail_Channels' => $staticField['StaticField']['videoDetail_Genres'],
						'videoDetail_Votes' => $staticField['StaticField']['videoDetail_Votes'],
						'videoDetail_Duration' => $staticField['StaticField']['videoDetail_Duration'],
						'videoDetail_Views' => $staticField['StaticField']['videoDetail_Views'],
						'videoDetail_DateAdded' => $staticField['StaticField']['videoDetail_DateAdded'],
						'videoDetail_Back' => $staticField['StaticField']['videoDetail_Back'],
						'videoDetail_RemoveFav' => $staticField['StaticField']['videoDetail_RemoveFav'],
						'videoDetail_Voted' => $staticField['StaticField']['videoDetail_Voted'],
						'videoDetail_Share' => $staticField['StaticField']['videoDetail_Share'],
						'defaultLanguageSetTo' => $staticField['StaticField']['defaultLanguageSetTo'],
						'text_cancel' => $staticField['StaticField']['text_cancel'],
						'text_ok' => $staticField['StaticField']['text_ok'],
						'remove_FromFavourite' => $staticField['StaticField']['remove_FromFavourite'],
						'Release_to_refresh' => $staticField['StaticField']['Release_to_refresh'],
						'Pull_to_refresh' => $staticField['StaticField']['Pull_to_refresh'],
						'Getting_new_videos' => $staticField['StaticField']['Getting_new_videos'],
						'Load_more_videos' => $staticField['StaticField']['Load_more_videos'],
						'searchBarPlaceholderText' => $staticField['StaticField']['searchBarPlaceholderText'],
						'ServerErrorText' => $staticField['StaticField']['ServerErrorText'],
						'InternetErrorText' => $staticField['StaticField']['InternetErrorText'],
						'watch_text' => $staticField['StaticField']['watch_text'],
						'on_text' => $staticField['StaticField']['on_text'],
						'Server_Error' => $staticField['StaticField']['Server_Error'],
						'Internet_Error' => $staticField['StaticField']['Internet_Error'],
						'NoFavoriteText' => $staticField['StaticField']['NoFavoriteText'],
						'Subscribe_Text' => $staticField['StaticField']['Subscribe_Text']
					);
	
	foreach($languageStaticFields as $languageStaticField){
		$arrLanguageStaticField[] = array(
								'id'=>$languageStaticField['LanguageStaticField']['id'], 
								'language_id'=>$languageStaticField['LanguageStaticField']['language_id'], 
								'title'=>$languageStaticField['LanguageStaticField']['title'],
								'code'=>$languageStaticField['LanguageStaticField']['code']
							);	
	}
		
			
	$arr = array('error'=>'0','errorMessage'=>'success','device'=>$arrDevice,'staticField'=>$arrStaticField,'languageList'=>$arrLanguageStaticField);
}else{
	$arr = array('error'=>'1','errorMessage'=>'error','device'=>$arrDevice,'staticField'=>$arrStaticField,'languageList'=>$arrLanguageStaticField);
}

// Json encode the array and print the same
echo json_encode($arr);
exit;

?>