<section class="mainContentBlock">
	<h2><?php echo __('Send Notification'); ?></h2>
	<section class="hrRow2px"></section>
	<?php echo $this->Session->flash(); ?>
	<section class="registrationContainer2">
	
		<?php echo $this->Form->create('Notification'); ?>
			<?php

				echo '<fieldset><label> Message <span class="error">*</span></label><span class="regisrtTxtDescfld">'.$this->Form->input('Notification.message', array('type'=>'textarea','label'=>false, 'div'=>false, 'maxlength'=>50)).'</span></fieldset>';
			?>
			<fieldset>
				<?php
					echo $this->Form->submit('Send', array('class'=>'submitBtn add-button', 'div'=>false));
					echo $this->Html->link($this->Html->image("cancel_button.png", array("alt"=>"Cancel")),array('controller'=>'videos','action' => 'admin_index'),array('escape'=>false));
					echo $this->Html->link('Analytics',"https://dashboard.pushy.me/",array('target'=> "_blank",'escape'=>false,'class'=>'inline add-button'));
				?>	
				
				
			</fieldset>
			<fieldset></fieldset>
		<?php echo $this->Form->end(); ?>
	</section>
</section>