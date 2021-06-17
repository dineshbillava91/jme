<?php

$flag = false;
$arr = array();
$arrLanguages = array();
$languageCount = count($languages);

if(!empty($languages)){
	foreach($languages as $language){
		$arr[] = array(
						'id' => $language['Language']['id'],
						'name' => ucwords($language['Language']['name'])
					);
	}
}

if($languageCount > 0 || $languageCount == 0){
	$flag = true;
}

if($flag){
	$arrLanguages = array('error'=>'0','errorMessage'=>'success','languageCount'=>$languageCount,'languageList'=>$arr);
}else{
	$arrLanguages = array('error'=>'1','errorMessage'=>'error','languageCount'=>0,'languageList'=>$arr);
}

echo json_encode($arrLanguages);
exit;

?>