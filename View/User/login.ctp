<div id="content">
	<div class="container">
		<div class="section span6 offset3">
			<div class="row-fluid">
				<?php echo $this->Form->create(null, array('url' => array('controller' => 'user', 'action'=>'login')));?>
				<div class="section-header">
					<h3><?php  echo __('Login'); ?></h3>
					<div class="section-actions">
						<?php if(Configure::read('Authake.registration') == true){?>
						<?php echo $this->Html->link(__("I forgot my password..."), array('action'=>'lost_password'),array('class'=>'btn btn-mini')); ?>
						 <?php echo $this->Html->link(__("Sign In"), array('action'=>'register'), array('class'=>'btn btn-success btn-mini'))?>
						<?php };?>
					</div>
				</div>
				<div class="section-body">
					<?php 
					echo $this->Form->input('login', array('label'=>'Login', 'size'=>'14'));
					echo $this->Form->input('password', array('label'=>'Password', 'value' => '', 'size'=>'14'));
					?>
				</div>
				<div class="section-footer">
					<div class="control-group">
						<div class="form-actions">
						<?php echo $this->Form->end(array('div'=>false,'label'=>'Login','class'=>'action input-action btn btn-info'));?>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>