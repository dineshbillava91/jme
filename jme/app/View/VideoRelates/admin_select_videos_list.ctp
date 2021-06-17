<?php
$html = '';

$html .= '<label class="videolbl">Selected Videos</label><span class="regisrtSelectfld"><select id="VideoRelateSelectedVideo" multiple="multiple" name="data[VideoRelate][selected_video][]">';
	
	foreach($videoLanguages as $videoLanguage){
		$html .= '<option rel="'.$videoLanguage['Video']['id'].'" value="'.$videoLanguage['Video']['id'].'">'.html_entity_decode(substr($videoLanguage['VideoLanguage']['title'],0,30), ENT_QUOTES).'</option>';
	}
	
$html .= '</select></span><section class="pagination">'.$this->Paginator->prev(__('<< previous '), array(), null, array('class' => 'prev disabled')).' '.$this->Paginator->numbers(array('separator' => '')).' '.$this->Paginator->next(__(' next >>'), array(), null, array('class' => 'next disabled')).'</section>';

echo $html;
exit;

?>