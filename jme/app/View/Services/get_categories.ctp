<?php 

$flag = false;
$arr = array();
$arrCategories = array();
$categoryCount = count($categoryLanguages);

if(!empty($categoryLanguages) && count($categoryLanguages) > 0){
	foreach($categoryLanguages as $categoryLanguage){
		
		// Store the value in variables
		$key = $categoryLanguage['Category']['id'];
		
		if($categoryLanguage['CategoryLanguage']['language_id'] == 'en'){
			$value = html_entity_decode($categoryLanguage['CategoryLanguage']['name'], ENT_QUOTES);
		}else{
			$value = $categoryLanguage['CategoryLanguage']['name'];
		}
		// Store the value in array
		$arr[] = array('id'=>$key, 'name'=>$value);
	}
}

if($categoryCount > 0 || $categoryCount == 0){
	$flag = true;
}

// Check whether $flag is true or false
if($flag){
	// Store values in $arrCategories array along with errorcode and error_message
	$arrCategories = array('error'=>'0','errorMessage'=>'success','categoryCount'=>$categoryCount,'categoryList'=>$arr);
}else{
	// Store values in $arrCategories array along with errorcode and error_message
	$arrCategories = array('error'=>'1','errorMessage'=>'error','categoryCount'=>0,'categoryList'=>$arr);
}

// Json encode the array and print the same
echo json_encode($arrCategories);
exit;

?>