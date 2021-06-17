<?php echo $this->Session->flash(); ?>
<section class="loginOuterBox"  style="top:55%">
	<section class="loginBox">
		<h2><?php echo __('Admin Login'); ?></h2>

		<?php echo $this->Form->create('User'); ?>
			
			<section class="loginForm">
				<fieldset>
					<label>Username<span class="error">*</span></label>
					<span class="loginTxtFld">
						<?php echo $this->Form->input('User.username', array('label'=>false, 'div'=>false, 'maxlength'=>20)); ?>
					</span>
				</fieldset>
				<fieldset>
					<label>Password<span class="error">*</span></label>
					<span class="loginTxtFld">
						<?php echo $this->Form->input('User.password', array('label'=>false, 'div'=>false, 'maxlength'=>20)); ?>
					</span>
				</fieldset>
				<fieldset style="width:380px;">
					<?php echo $this->Form->checkbox('User.remember_me', array('value'=>1,'checked'=>(isset($this->request->data) && !empty($this->request->data) && $this->request->data['User']['remember_me'] == 1 ? 'checked' : ''))); ?><p>Remember Me</p>

					<p style="float:right">
						<a style="color:#000" href="<?php echo $this->webroot ?>forgot">Forgot Password</a>
					</p>

				</fieldset>
				<?php echo $this->Form->submit('admin_sign_in_btn.png', array('class'=>'continuewBTN', 'div'=>false)); ?>
			</section>
		<?php echo $this->Form->end(); ?>
	</section>
</section>