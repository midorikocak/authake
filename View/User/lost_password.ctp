<div id="content">
	<div class="container">
		<div class="section span6 offset3">
			<div class="row-fluid">
				<?php echo $this->Form->create(null, array('url' => array('controller' => 'user', 'action'=>'lost_password')));?>
				<div class="section-header">
					<h3><?php  echo __('Lost Password'); ?></h3>
				</div>
				<div class="section-body">
					<?php echo $this->Form->input('loginoremail', array('label'=>__('Login or email'), 'size'=>'40'));?>
				</div>
				<div class="section-footer">
					<div class="control-group">
						<div class="form-actions">
						<?php echo $this->Form->end(array('div'=>false,'label'=>'Request for password','class'=>'action input-action btn btn-info'));?>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>