<script type="text/javascript">
	$(document).ready(function(){
		video_id = $('#video_id').html();
		$.ajax({
			type: 'POST',
			url: '/admin/video_relates/select_videos_list',
			data: {'data[Video][id]':video_id},
			success: function(response){
				$('#select_videos_list').html(response);
			}
		});
		$('.pagination a').live('click',function(){
			var url = $(this).attr('href');
			var selected_id = '';
			var relatedVideoIds = '';
			
			var i = true;
			$('#VideoRelateRelatedVideo option').each(function(){
				selected_id = $(this).val();
				
				if(i){
					relatedVideoIds = selected_id;
					i = false;
				}else{
					relatedVideoIds += ', '+selected_id;
				}
			});
			
			$.ajax({
				type: 'POST',
				url: url,
				data: {'data[Video][id]':video_id, 'data[VideoRelate][related_video_ids]':relatedVideoIds},
				success: function(response){
					$('#select_videos_list').html(response);
				}
			});
			return false;
		});
	});
</script>

<?php 
echo $this->Html->css('autocomplete/jquery-ui.css');
echo $this->Html->script('autocomplete/jquery-ui.js');
echo $this->Html->script('autocomplete/custom.autocomplete.js');
?>

<section class="mainContentBlock">
	<h2><?php echo __('Manage Related Videos'); ?></h2>
	<section class="searchTop">
		<?php echo $this->Html->link(__('Back'), array('controller'=>'videos', 'action'=>'edit/'.$video_id)); ?>
	</section>
	<section class="hrRow2px"></section>
	<?php echo $this->Session->flash(); ?>
	<section class="registrationContainer3">
		<fieldset class="srchfldset">
			<label class="searchlbl">Director</label>
			<span class="regisrtTxtfld">
				<?php echo $this->Form->input('VideoRelate.director', array('label'=>false, 'div'=>false)); ?>
			</span>
		</fieldset>
		<fieldset class="srchfldset">
			<label class="searchlbl">Category</label>
			<span class="regisrtTxtfld">
				<?php echo $this->Form->select('VideoRelate.category_id', $categories, array('label'=>'Categories','empty'=>'Select')); ?>
			</span>
		</fieldset>
		<fieldset class="srchfldset" style="margin-left:10px; margin-top:5px;">
			<?php echo $this->Html->link($this->Html->image("show_videos.png", array("alt"=>"Show Videos")),'javascript:void(0);',array('id'=>'show_videos', 'escape'=>false)); ?>
		</fieldset>
		<fieldset class="srchfldset"></fieldset>
	</section>
	<section style="float:left; margin:10px;"></section>
	<section class="registrationContainer3">
		<?php echo $this->Form->create('VideoRelate'); ?>
			<fieldset class="videofldset" id="select_videos_list"></fieldset>
			<fieldset class="videofldset" style="width:200px;">
				<?php
					echo $this->Html->link($this->Html->image("arrow_right.png", array("alt"=>"Arrow Right")),'javascript:void(0);',array('id'=>'moveToRelated', 'escape'=>false));
					
					echo $this->Html->link($this->Html->image("arrow_left.png", array("alt"=>"Arrow Left")),'javascript:void(0);',array('id'=>'moveToSelected', 'escape'=>false));
				?>
			</fieldset>
			<fieldset class="videofldset">
				<label class="videolbl">Related Videos</label>
				<span class="regisrtSelectfld">
					<?php 
						echo $this->Form->select('VideoRelate.related_video', '', array('multiple'=>true)); 
						echo $this->Form->input('VideoRelate.related_video_ids', array('type'=>'hidden')); 
					?>
				</span>
			</fieldset>
			<fieldset class="srchfldset" style="width:100%;">
				<?php
					echo $this->Html->link($this->Html->image('save_button.png', array('class'=>'submitBtnVideoRelate', 'alt'=>'Save')),'javascript:void(0);',array('id'=>'saveAddRelatedVideos', 'escape'=>false));
					echo $this->Html->link($this->Html->image("cancel_button.png", array("alt"=>"Cancel")),array('controller'=>'videos', 'action' => 'admin_index'),array('escape'=>false));
				?>
			</fieldset>
			<fieldset class="srchfldset"></fieldset>
			<fieldset id="video_id" style="display:none;"><?php echo $video_id; ?></fieldset>
		<?php echo $this->Form->end(); ?>
	</section>
</section>