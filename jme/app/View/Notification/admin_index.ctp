<section class="mainContentBlock">
	<h2><?php echo __('Manage Notification'); ?></h2>
	<section class="hrRow2px"></section>
	<?php echo $this->Session->flash(); ?>
	<section class="filterContainer2">
		<section>
			<?php echo $this->Html->link('Analytics',"https://dashboard.pushy.me/",array('target'=> "_blank",'escape'=>false,'class'=>'add-button')); ?>
			<?php echo $this->Html->link('Send Notification',array('action' => 'admin_add'),array('escape'=>false,'class'=>'add-button')); ?>
		</section>
	</section>

	<section class="manageBidsArea">
		<section class="bidsList grayBg">
			<span class="col100 nonSkyBlueBold"><?php echo 'id'; ?></span>
			<span class="col600 nonSkyBlueBold"><?php echo 'Message'; ?></span>
			<span class="col200 nonSkyBlueBold"><?php echo 'Date & Time'; ?></span>
		</section><?php
		
		$i = 0;
		if (!empty($notification) && count($notification) > 0) {
			foreach ($notification as $record): ?>
				<section class="bidsList <?php if($i%2!=0){echo "grayBg";}?>">
					<span class="col100"><?php echo h($record['Notification']['id']); ?></span>
					<span class="col600"><?php echo html_entity_decode(substr($record['Notification']['message'],0,40)); ?></span>
					<span class="col200"><?php 
						echo $record['Notification']['created']; 
					?></span>
				</section><?php 
				$i++;
			endforeach; 
		}else{
			echo '<section class="bidsList"><span class="col900">No Record Available</span></section>';
		} ?>
	</section>
	<section class="pagination">
		<?php
			echo $this->Paginator->prev(__('previous'), array(), null, array('class' => 'prev disabled'));
			echo "|";
			echo $this->Paginator->numbers(array('separator' => '|'));
			echo "|";
			echo $this->Paginator->next(__('next'), array(), null, array('class' => 'next disabled'));
		?>
	</section>
</section>