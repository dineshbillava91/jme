<script>
	$(function(){
		$('.col150.series').each(function(){
			$(this).hover(function(){
				var hiddenVal = $(this).find('input[type=hidden]').val();
				$(this).find('.tool-tip').show();
			});
			$(this).mouseout(function(){
				$(this).find('.tool-tip').hide();
			});
		});
	});	
</script>
<section class="mainContentBlock">
	<h2><?php echo __('Manage Banners'); ?></h2>
	<?php echo $this->Session->flash(); ?>
	<section class="filterContainer2">
		<section>
			<?php
				$options = array('5'=>5,'30'=>30,'60'=>60,'90'=>90,'120'=>120,'150'=>150);
				echo $this->Form->create('Banner', array('action'=>'updateRefreshRate', 'class'=> 'rrate-form'));
				echo $this->Form->input('refresh_rate', array('options' =>$options , 'value'=>$refresh_rate));
				echo $this->Form->submit('Update');
				echo $this->Form->end();
			?>
		</section>
	</section>
	<section class="filterContainer2">
		<section>
			<?php echo $this->Html->link('Add Banner',array('action' => 'admin_add'),array('escape'=>false,'class'=>'add-button')); ?>
		</section>
	</section>
	<section class="manageBidsArea">
		<section class="bidsList grayBg">
			<span class="col200 nonSkyBlueBold">Banner Thumbnail</span>
			<span class="col200 nonSkyBlueBold">Link</span>
			<span class="actions nonSkyBlueBold"><?php echo 'Action'; ?></span>
		</section><?php
		
		$k = 0;
		
		foreach($banners as $banner){
			$banner = $banner['Banner'];
		
		?>
				
				<section class="bidsList <?php if($k%2!=0){echo "grayBg";}?>">
					<span class="col200 colheight">
						<img src="<?php echo $this->webroot; ?>uploads/banners/<?php echo $banner['banner']; ?>" width="200"/>
					</span>
					<span class="col200 colheight"><?php 
						if(!empty($banner['link'])){ echo $banner['link']; }
						else{ echo '(Link not associated)'; }
					?></span>
					<span class="actions">
						<?php echo $this->Html->link(__('Edit'), array('action' => 'edit', $banner['id'])); ?>
						|
						<?php 
							if($banner['status']==0)
							{
								$action="deactivate";
								$link_title = "delete";
							}
							else
							{
								$action="activate";
								$link_title = "activate";
							}
							echo $this->Form->postLink(__(ucfirst($link_title)),array('action' => $action,$banner['id']),null,__('Are you sure you want to '.$link_title.'?'));
						?>
					</span>
				</section><?php 
			$k++;
		}
		?>
	</section>
	<section class="pagination">
		<?php
			//~ echo $this->Paginator->prev(__('previous'), array(), null, array('class' => 'prev disabled'));
			//~ echo "|";
			//~ echo $this->Paginator->numbers(array('separator' => '|'));
			//~ echo "|";
			//~ echo $this->Paginator->next(__('next'), array(), null, array('class' => 'next disabled'));
		?>
	</section>
</section>
