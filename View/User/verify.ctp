<div id="content">
	<div class="container">
		<div class="section span6 offset3">
			<div class="row-fluid">
				<?php echo $this->Form->create(null, array('url' => array('controller' => 'user', 'action'=>'verify')));?>
				<div class="section-header">
					<h3><?php  echo __('Verify'); ?></h3>
				</div>
				<div class="section-body">
					<?php 
					echo $this->Form->input('code', array('size'=>'40', 'title'=>__('Please insert the code which you received in your e-mail.')));
					?>
				</div>
				<div class="section-footer">
					<div class="control-group">
						<div class="form-actions">
						<?php echo $this->Form->end(array('div'=>false,'label'=>'Confirm','class'=>'action input-action btn btn-info'));?>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>