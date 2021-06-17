<?php if(isset($id) && !empty($id)){ ?>
	<nav>
		<ul class="merchant">
			<li class="mainNav <?php echo ($selected_tab == 'video' ? 'selectedTab' : ''); ?>">
				<a href="<?php echo $this->webroot."admin/videos" ?>" title="VIDEOS">VIDEOS</a>
			</li>
			<li class="mainNav <?php echo ($selected_tab == 'category' ? 'selectedTab' : ''); ?>">
				<a href="<?php echo $this->webroot."admin/categories" ?>" title="DEPARTMENTS">DEPARTMENTS</a>
			</li>
			<li class="mainNav <?php echo ($selected_tab == 'tvseries' ? 'selectedTab' : ''); ?>">
				<a href="<?php echo $this->webroot."admin/tvseries" ?>" title="SECTION">SECTION</a>
			</li>
			<li class="mainNav <?php echo ($selected_tab == 'banners' ? 'selectedTab' : ''); ?>">
				<a href="<?php echo $this->webroot."admin/banners" ?>" title="BANNERS">BANNERS</a>
			</li>
			<li class="mainNav <?php echo ($selected_tab == 'notification' ? 'selectedTab' : ''); ?>">
				<!-- <a href="https://www.parse.com/apps/cvnet--2/push_notifications" target="_blank" title="NOTIFICATIONS">NOTIFICATIONS</a> -->
				<!-- <a href="https://go.pushwoosh.com/applications/9020E-572FD" target="_blank" title="NOTIFICATIONS">NOTIFICATIONS</a> -->
				<a href="<?php echo $this->webroot."admin/notification" ?>" title="NOTIFICATIONS">NOTIFICATIONS</a>				
			</li>
		</ul>
	</nav>
<?php } ?>
