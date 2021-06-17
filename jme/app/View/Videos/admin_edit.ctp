<section class="mainContentBlock">
	<h2><?php echo __('Edit Video'); ?></h2>
	<section class="searchTop">
		<?php echo $this->Html->link(__('Back'), array('action' => 'index')); ?>
	</section>
	<section class="hrRow2px"></section>
	<?php echo $this->Session->flash(); ?>
	<section class="registrationContainer2">
	
		<?php echo $this->Form->create('Video', array('type' => 'file')); ?>
			<?php
				
				foreach($languages as $key => $value){
					echo $this->Form->input('VideoLanguage.id_'.$key, array('type'=>'hidden'));
				}
		
				$i = 1;
				foreach($languages as $key => $value){
					if($i == 1){
						echo '<fieldset><label>Video Title ('.ucwords($value).')<span class="error">*</span></label><span class="regisrtTxtfld">'.$this->Form->input('VideoLanguage.title_'.$key, array('label'=>false, 'div'=>false, 'maxlength'=>50)).'</span></fieldset>';
					}else{
						echo '<fieldset><label>Video Title ('.ucwords($value).')</label><span class="regisrtTxtfld">'.$this->Form->input('VideoLanguage.title_'.$key, array('label'=>false, 'div'=>false, 'maxlength'=>50)).'</span></fieldset>';
					}
					$i++;
				}
				
				$j = 1;				
				foreach($languages as $key => $value){
			//	echo $this->data['VideoLanguage']['description_'.$key];
					if($j == 1){
						echo '<fieldset><label>Video Description ('.ucwords($value).')<span class="error">*</span></label><span class="regisrtTxtDescfld">'.$this->Form->input('VideoLanguage.description_'.$key, array('type'=>'textarea', 'label'=>false, 'div'=>false)).'</span></fieldset>';
					}else{
						echo '<fieldset><label>Video Description ('.ucwords($value).')</label><span class="regisrtTxtDescfld">'.$this->Form->input('VideoLanguage.description_'.$key, array('type'=>'textarea', 'label'=>false, 'div'=>false)).'</span></fieldset>';
					}
					$j++;
				}
			?>
			<fieldset>
				<label>Enter Video URL<span class="error">*</span></label>
				<span class="regisrtTxtfld">
					<?php echo $this->Form->input('Video.video_url', array('label'=>false, 'div'=>false, 'required'=>'required')); ?>
				</span>
			</fieldset>
			<fieldset>
				<label>Enter Video Duration<span class="error">*</span></label>
				<span class="regisrtTxtfld">
					<?php //echo $this->Form->input('Video.video_url', array('label'=>false, 'div'=>false)); ?>
					
					<?php echo $this->Form->input('Video.video_duration', array('label'=>false, 'div'=>false, 'type' => "text", 'required'=>'required')); ?>
				</span>
			</fieldset>
			<fieldset>
				<label>Update Video Thumbnail<span class="error">*</span><small><br/>(150x120)</small></label>
				<span class="regisrtTxtfld">
					<?php echo $this->Form->file('Video.video_thumbnail', array('label'=>false, 'div'=>false, 'type'=>'file')); ?>
				</span>
					<?php
						//PRINT: the file uploaded name
						if(!empty($this->request->data['Video']['video_thumbnail'])){
							//echo $this->request->data['Video']['video_thumbnail'];
							echo $this->Form->input('Video.old_thumbnail', array('type'=>'hidden', 'value'=>$this->request->data['Video']['video_thumbnail']));
						}else{ 
					?>
				<span class="success-text">
					<?php	echo $this->Form->input('Video.old_thumbnail', array('type'=>'hidden', 'value'=>''));
							echo 'Thumbnail not associated.';
					?>
				</span>
					<?php
						}
					?>
			</fieldset>
			<?php if(!empty($this->request->data['Video']['video_thumbnail'])){ ?>
				<fieldset>
					<label></label>
					<span class="video-thumbnail">
						<img src="<?php echo $this->webroot; ?>uploads/video/<?php echo $this->request->data['Video']['video_thumbnail']; ?>" width="200" />
					</span>
				</fieldset>
			<?php } ?>
			<fieldset>
				<label>Departments</label>
				<span class="regisrtSelectfld">
					<?php 
						echo $this->Form->input('VideoCategory.id', array('type'=>'hidden'));
						echo $this->Form->input('VideoCategory.category_id', array('type'=>'select', 'label'=>false, 'div'=>false, 'options'=>$categories, 'multiple'=>true));
					?>
				</span>
			</fieldset>
			<fieldset>
				<label>Select Series</label>
				<span class="regisrtSelectfld series">
					<?php echo $this->Form->input('VideoTvseries.id', array('type'=>'hidden')); ?>
					<?php echo $this->Form->input('VideoTvseries.tvseries_id', array('type'=>'select', 'label'=>false, 'div'=>false,'class'=>'series', 'options'=>$series)); ?>
				</span>
			</fieldset>
			<?php /* <fieldset>
					<label>Related Videos</label>
					<section class="secRelatedVideos">
					<?php echo $totalRelatedVideos; ?>
					<?php echo $this->Html->link(__('Edit'), array('controller'=>'video_relates', 'action'=>'admin_edit', $video_id));?>
					</section>
			</fieldset>
			*/ ?>
			<fieldset>
				<?php
					echo $this->Form->submit('save_button.png', array('class'=>'submitBtn', 'div'=>false));
					echo $this->Html->link($this->Html->image("cancel_button.png", array("alt"=>"Cancel")),array('action' => 'admin_index'),array('escape'=>false));
				?>
			</fieldset>
			<fieldset></fieldset>
		<?php echo $this->Form->end(); ?>
		
	</section>
</section>
