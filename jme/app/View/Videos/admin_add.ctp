<section class="mainContentBlock">
	<h2><?php echo __('Add Video'); ?></h2>
	<section class="searchTop">
		<?php echo $this->Html->link(__('Back'), array('action' => 'index')); ?>
	</section>
	<section class="hrRow2px"></section>
	<?php echo $this->Session->flash(); ?>
	<section class="registrationContainer2">
	
		<?php  echo $this->Form->create('Video', array('type' => 'file')); ?>
			<?php
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
					<?php echo $this->Form->input('Video.video_duration', array('label'=>false, 'div'=>false, 'type' => "text", 'required'=>'required')); ?>
				</span>
			</fieldset>
			<fieldset>
				<label>Add Video Thumbnail<span class="error">*</span><small><br/>(150x120)</small></label>
				<span class="regisrtTxtfld">
					<?php echo $this->Form->file('Video.video_thumbnail', array('label'=>false, 'div'=>false, 'type'=>'file', 'required'=>'required')); ?>
				</span>
			</fieldset>
			<fieldset>
				<label></label>
				<span class="video-thumbnail"></span>
			</fieldset>
			<fieldset>
				<label>Departments</label>
				<span class="regisrtSelectfld">
					<?php echo $this->Form->input('VideoCategory.category_id', array('type'=>'select', 'label'=>false, 'div'=>false, 'options'=>$categories, 'multiple'=>true)); ?>
				</span>
			</fieldset>
			<fieldset>
				<label>Select Series</label>
				<span class="regisrtSelectfld series">
					<?php echo $this->Form->input('VideoTvseries.tvseries_id', array('type'=>'select', 'label'=>false, 'div'=>false, 'class'=>'series', 'options'=>$series)); ?>
				</span>
			</fieldset>
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
