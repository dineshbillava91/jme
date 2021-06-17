<section class="mainContentBlock">
	<h2><?php echo __('Edit Section'); ?></h2>
	<section class="hrRow2px"></section>
	<?php echo $this->Session->flash(); ?>
	<section class="registrationContainer">
		<?php //echo '<pre>';print_r($this->request->data);exit; ?>
		<?php echo $this->Form->create('TV Series'); ?>
			<?php
				// echo $this->Form->input('id');
				foreach($languages as $key => $value){
					echo '<fieldset><label>Section ('.ucwords($value).')<span class="error">*</span></label><span class="regisrtTxtfld">'.$this->Form->input('Tvseries.title_'.strtolower($value), array('label'=>false, 'div'=>false, 'maxlength'=>50)).'</span></fieldset>';
				}
			?>
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