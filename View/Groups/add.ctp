<div id="authake">
<div class="actions menuheader">
    <ul>
        <li class="icon group"><?php echo $this->Html->link(__('Manage groups'), array('action'=>'index'));?></li>
    </ul>
</div>
<div class="groups form">
<?php echo $this->Form->create('Group');?>
	<fieldset>
        <legend><?php echo __('Create a new group');?></legend>   
	<?php
		echo $this->Form->input('name', array('label'=>__('Name')));
        echo $this->Form->input('User', array('label'=>__('Users in this group<br/>Press \'Control\' for multi-selection'), 'style'=>'width: 15em;'));
	?>
	</fieldset>
<?php echo $this->Form->end(__('Create'));?>
</div>
</div>
