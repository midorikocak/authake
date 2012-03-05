<div id="authake">
<?php echo $this->element('gotohomepage'); ?>
<div class="login form">
<?php echo $this->Form->create(null, array('action'=>'login'));?> 
<fieldset>
    <?php
        echo $this->Form->input('login', array('label'=>__('Login'), 'size'=>'14'));
        echo $this->Form->input('password', array('label'=>__('Password'), 'value' => '', 'size'=>'14'));
    ?>
</fieldset>
<?php echo $this->Form->end(__('Login'))  ?>
<?php if(Configure::read('Authake.registration') == true){?>
    <p class="lostpassword" style="margin-left: 16em;"><?php echo $this->Html->link(__("I forgot my password..."), array('action'=>'lost_password'))."<br/>"; ?></p>
<?php /*    <p class="register" style="margin-left: 16em;"><?php echo $this->Html->link(__("Register yourself"), array('action'=>'register'))."<br/>"; ?></p> */ ?>
<?php };?>
</div>
</div>
