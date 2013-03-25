<div id="content">
	<div class="container">
		<div class="section span6 offset3">
			<div class="row-fluid">
				<?php echo $this->Form->create(null, array('url' => array('controller' => 'user', 'action'=>'register')));?>
				<div class="section-header">
					<h3><?php  echo __('Register'); ?></h3>
				</div>
				<div class="section-body">
					<?php
					if ( ! Configure::read('Authake.useEmailAsUsername') ) echo $this->Form->input('login', array('label'=>__('Login'), 'size'=>'12')); 
				    // do not show if we're using emails as usernames
				    echo $this->Form->input('email', array('label'=>__('Email'), 'size'=>'40'));
				    echo $this->Form->input('password1', array('type'=>'password', 'label'=>__('Password'), 'value' => '', 'size'=>'12'));
				    echo $this->Form->input('password2', array('type'=>'password', 'label'=>__('Please, re-enter password'), 'value' => '', 'size'=>'12'));
					?>
				</div>
				<div class="section-footer">
					<div class="control-group">
						<div class="form-actions">
						<?php echo $this->Form->end(array('div'=>false,'label'=>'Register','class'=>'action input-action btn btn-success'));?>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>