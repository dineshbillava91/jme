<?php echo $this->Session->flash(); ?>
<section class="loginOuterBox" style="top:55%">
	<section class="loginBox">
		<h2><?php echo __('Forgot Password'); ?></h2>

		<?php echo $this->Form->create('User'); ?>
			
			<section class="loginForm">
				<fieldset>
					<label>Username<span class="error">*</span></label>
					<span class="loginTxtFld">
						<?php echo $this->Form->input('User.username', array('label'=>false, 'div'=>false, 'maxlength'=>20)); ?>
					</span>
				</fieldset>
				<?php //echo $this->Form->submit('admin_sign_in_btn.png', array('class'=>'continuewBTN', 'div'=>false)); ?>

				<input type="submit" value="Send Email" style=" border-radius: 5px;cursor: pointer;float: left;margin: 10px 0 10px 20px;padding: 10px;" />
				<p style="float: left; margin: 16px;">
					<span style=" background: #f0f0f0 none repeat scroll 0 0;border-radius: 5px;padding: 10px;">
						<a style="color:#000;font-size:12px;" href="<?php echo $this->webroot ?>">Back to login</a>
					</span>
				</p>
				<!-- <a href="<?php echo $this->webroot ?>"style=" border-radius: 5px;cursor: pointer;margin: 10px 0 10px 20px;padding: 10px;">Back To Login</a> -->
			</section>
		<?php echo $this->Form->end(); ?>
	</section>
</section>