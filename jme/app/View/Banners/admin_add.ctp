<section class="mainContentBlock">
	<h2><?php echo __('Add Banner'); ?></h2>
	<section class="searchTop">
		<?php echo $this->Html->link(__('Back'), array('action' => 'index')); ?>
	</section>
	<section class="hrRow2px"></section>
	<?php echo $this->Session->flash(); ?>
	<section class="registrationContainer2">
	
		<?php  echo $this->Form->create('Banner', array('type' => 'file')); ?>
			
			<fieldset>
				<label>
					Add Banner<span class="error">*</span>
					<small><br/>(320x50)</small>
				</label>
				<span class="regisrtTxtfld">
					<?php echo $this->Form->input('Banner.banner', array('type'=>'file', 'label'=>false, 'div'=>false, 'required'=>'required')); ?>
				</span>
			</fieldset>
			<fieldset>
				<label></label>
				<span class="video-thumbnail" style="width:200px"></span>
			</fieldset>
			<fieldset>
				<label>Enter Banner Link</label>
				<span class="regisrtTxtfld">
					<?php echo $this->Form->input('Banner.link', array('label'=>false, 'div'=>false, 'type'=>'url')); ?>
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
