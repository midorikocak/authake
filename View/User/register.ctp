<div id="authake">
<?php echo $this->element('gotohomepage'); ?>
<div class="register form">
<?php echo $this->Form->create(null, array('action'=>'register'));?>
	<fieldset>
 		<legend><?php __('Registration');?></legend>
<?php
        
    if ( ! Configure::read('Authake.useEmailAsUsername') ) echo $this->Form->input('login', array('label'=>__('Login'), 'size'=>'12')); 
    // do not show if we're using emails as usernames
    echo $this->Form->input('email', array('label'=>__('Email'), 'size'=>'40'));
    echo $this->Form->input('password1', array('type'=>'password', 'label'=>__('Password'), 'value' => '', 'size'=>'12'));
    echo $this->Form->input('password2', array('type'=>'password', 'label'=>__('Please, re-enter password'), 'value' => '', 'size'=>'12'));
        
    echo $this->Form->end(__('Register'));
?>
	</fieldset>
</div>
</div>




