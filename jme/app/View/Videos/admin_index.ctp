<?php

/* $first = true;
$series = '';

foreach($videoLanguages as $videoLanguage)
{
	foreach($videoLanguage['Video']['VideoTvseries'] as $result){
		if(!empty($result['Tvseries']['id'])){
			if($first){
				$series = $result['Tvseries']['title_english'];
				$first = false;
			}else{
				$series .= ', '.$result['Tvseries']['title_english'];
			}
		}
		echo substr(h($series),0,20);
	}
}
exit;
 */


?>
<script>
	$(function(){
		$('.col150.series').each(function(){
			$(this).hover(function(){
				var hiddenVal = $(this).find('input[type=hidden]').val();
				$(this).find('.tool-tip').show();
			});
			$(this).mouseout(function(){
				$(this).find('.tool-tip').hide();
			});
		});
	});	
</script>
<section class="mainContentBlock">
	<h2><?php echo __('Manage Videos'); ?></h2>
	<section class="searchTop">
		<?php echo $this->Form->create('Video'); ?>
			<fieldset>
				<span class="regisrtTxtfld"><?php echo $this->Form->input('Video.name', array('label'=>false, 'div'=>false)); ?></span>
			</fieldset>
			<fieldset>			
				<?php echo $this->Html->image("search.png", array('id'=>'search_videos','class'=>'submitBtn','alt'=>'Add Video')); ?>
			</fieldset>
		<?php echo $this->Form->end(); ?>
	</section>
	<section class="hrRow2px"></section>
	<?php echo $this->Session->flash(); ?>
	<section class="filterContainer2">
		<section>
			<?php echo $this->Html->link('Add Video',array('action' => 'admin_add'),array('escape'=>false,'class'=>'add-button')); ?>
		</section>
	</section>
	
	<section class="manageBidsArea">
		<section class="bidsList grayBg">
			<span class="col200 skyblueBold"><?php echo $this->Paginator->sort('title','Video Title'); ?></span>
			<span class="col200 nonSkyBlueBold">Section</span>
			<span class="col200 nonSkyBlueBold">Departments</span>
			<span class="col200 skyblueBold"><?php echo $this->Paginator->sort('Video.created','Added On'); ?></span>
			<span class="actions nonSkyBlueBold"><?php echo 'Action'; ?></span>
		</section><?php
		
		$k = 0;
		
		// echo '<pre>';print_r($videoLanguages);exit;
		
		if (!empty($videoLanguages) && count($videoLanguages) > 0) {
			foreach ($videoLanguages as $videoLanguage): ?>
				
				<section class="bidsList <?php if($k%2!=0){echo "grayBg";}?>">
					<span class="col200"><?php echo html_entity_decode(substr($videoLanguage['VideoLanguage']['title'],0,20)); ?></span>
					<span class="col200">
						<?php 
							$first = true;
							$series = '';
							foreach($videoLanguage['Video']['VideoTvseries'] as $result){
								if(!empty($result['Tvseries']['id'])){
									if($first){
										$series = $result['Tvseries']['title_english'];
										$first = false;
									}else{
										$series .= ', '.$result['Tvseries']['title_english'];
									}
								}
							}
							echo substr(h($series),0,20);
						?>
					</span>
					<span class="col200 series">
						<?php 
							$first = true;
							$categories = '';
							foreach($videoLanguage['Video']['VideoCategory'] as $result){
								if($first){
									$categories = $result['Category']['name'];
									$first = false;
								}else{
									$categories .= ', '.$result['Category']['name'];
								}
							}
							echo substr(h($categories),0,20);
						?>
						<input type="hidden" value="<?php echo $categories; ?>" class="span_series" />
						<?php if(!empty($categories)){ ?><div class="tool-tip" ><?php echo $categories; ?></div><?php } ?>
					</span>
					<span class="col200">
						<?php echo date('m/d/Y', h($videoLanguage['Video']['created'])); ?>
					</span>
					<span class="actions">
						<?php echo $this->Html->link(__('Edit'), array('action' => 'edit', $videoLanguage['Video']['id'])); ?>
						|
						<?php 
							if($videoLanguage['Video']['status']==0)
							{
								$action="deactivate";
								$link_title = "delete";
							}
							else
							{
								$action="activate";
								$link_title = "activate";
							}
							echo $this->Form->postLink(__(ucfirst($link_title)), array('action' => $action, $videoLanguage['Video']['id']), null, __('Are you sure you want to '.$link_title.' %s?', $videoLanguage['VideoLanguage']['title'])); 
						?>
					</span>
				</section><?php 
				$k++;
			endforeach; 
		}else{
			echo '<section class="bidsList"><span class="col900">No Record Available</span></section>';
		}	?>
	</section>
	<section class="pagination">
		<?php
			echo $this->Paginator->prev(__('previous'), array(), null, array('class' => 'prev disabled'));
			echo "|";
			echo $this->Paginator->numbers(array('separator' => '|'));
			echo "|";
			echo $this->Paginator->next(__('next'), array(), null, array('class' => 'next disabled'));
		?>
	</section>
</section>
