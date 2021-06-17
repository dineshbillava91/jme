<?php 

	$flag = false;
	$arr = array();
	$tvseriesCount = count($tvseries);
	if(!empty($tvseries)){
		foreach($tvseries as $tvseriesRelate){
		
			$flg = true;
			$title = '';
			
			$tvseriesRelate['Tvseries']['created'] = strtotime($tvseriesRelate['Tvseries']['created']);
			
			$title = $tvseriesRelate['Tvseries']['title_english']; 
			
			if($language_id == 'es'){
				
			$title = $tvseriesRelate['Tvseries']['title_spanish'];
				
			}else if($language_id == 'fr'){
				
			$title = $tvseriesRelate['Tvseries']['title_french'];
			
			}
			
			// Resulted array
			$arr[] = array(
				'id' => $tvseriesRelate['Tvseries']['id'],
				'title' => $title,
				'dateAdded' => $tvseriesRelate['Tvseries']['created']
			);
		}
	}

	if($tvseriesCount > 0 || $tvseriesCount == 0){
		$flag = true;
	}
	
	if($flag){
		$arrGetRelatedSeriesList = array('error'=>'0','errorMessage'=>'success','tvseriesCount'=>$tvseriesCount,'tvseriesList'=>$arr);
	}else{
		$arrGetRelatedSeriesList = array('error'=>'1','errorMessage'=>'error','tvseriesCount'=>0,'tvseriesList'=>$arr);
	}
	
	echo json_encode($arrGetRelatedSeriesList);
	exit;
	
?>
