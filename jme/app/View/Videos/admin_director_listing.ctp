<?php
$str = '';
$flag = true;
if(!empty($videos) && count($videos) > 0){
	foreach($videos as $video){
		if($flag){
			$str = $video['Video']['director'];
			$flag = false;
		}else{
			$str .= ','.html_entity_decode(substr($video['Video']['director'],0,40), ENT_QUOTES);
		}
	}
}
echo $str;
exit;

?>