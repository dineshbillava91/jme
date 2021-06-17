<section class="mainContentBlock">
	<h2><?php echo __('Manage Section'); ?></h2>
	<section class="hrRow2px"></section>
	<?php echo $this->Session->flash(); ?>
	<section class="filterContainer2">
		<section>
			<?php echo $this->Html->link('Add Section',array('action' => 'admin_add'),array('escape'=>false,'class'=>'add-button')); ?>
		</section>
	</section>

	<section class="manageBidsArea">
		<section class="bidsList grayBg">
			<span class="col100 nonSkyBlueBold"><?php echo 'id'; ?></span>
			<span class="col300 nonSkyBlueBold"><?php echo 'Section'; ?></span>
			<span class="col200 nonSkyBlueBold"><?php echo 'Date'; ?></span>
			<span class="actions nonSkyBlueBold"><?php echo 'Action'; ?></span>
		</section><?php
		
		$i = 0;
		if (!empty($series) && count($series) > 0) {
			foreach ($series as $record): ?>
				
				<section class="bidsList <?php if($i%2!=0){echo "grayBg";}?>">
					<span class="col100"><?php echo h($record['Tvseries']['id']); ?></span>
					<span class="col300"><?php echo html_entity_decode(substr($record['Tvseries']['title_english'],0,40)); ?></span>
					<span class="col200"><?php 
						$datetime = explode(' ',$record['Tvseries']['created']);
						$date = explode('-',$datetime[0]);
						echo $date[2].'/'.$date[1].'/'.$date[0]; 
					?></span>
					<span class="actions">
						<?php echo $this->Html->link(__('Edit'), array('action' => 'edit', $record['Tvseries']['id'])); ?>
						|
						<?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $record['Tvseries']['id']), null, __('Are you sure you want to delete %s?', $record['Tvseries']['title_english'])); ?>
					</span>
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