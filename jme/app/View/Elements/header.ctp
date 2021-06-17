<header>
	<a href="<?php echo $this->webroot.'admin/videos' ?>" style="margin:20px 0px;display:block;float:left">
		<img src="<?php echo $this->webroot ?>img/b2bvb-logo.png" />
	</a>
	<?php if(isset($id) && !empty($id)) { ?>
		<ul class="merchant">
			<span class="userIcon">
				<img src="<?php echo $this->webroot ?>img/user_icon.gif" width="25" height="26" alt="userIcon"/>
			</span>
			<li>
				<a href="javascript:void(0)" title="Admin">Admin</a>
				<img src="<?php echo $this->webroot ?>img/top_nav_arrow.gif" width="9" height="4" alt="Arrow" />
				<ul>
					<li><a href="<?php echo $this->webroot."admin/users/change_password" ?>" title="Settings">Change Password</a></li>
					<li><a href="<?php echo $this->webroot."admin/users/logout" ?>" title="Signout">Sign-out</a></li>
				</ul>
			</li>
		</ul>
	<?php } ?>
</header>