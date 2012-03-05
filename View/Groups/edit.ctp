<div id="authake">
<div class="actions menuheader">
    <ul>
        <li class="icon group"><?php echo $this->Html->link(__('Manage groups'), array('action'=>'index'));?></li>
    </ul>
</div>
<div class="groups form">
<?php echo $this->Form->create('Group');?>
	<fieldset>
 	<legend><?php __('Modify group'); echo " ".$this->request->data['Group']['name']; ?></legend>
 	<?php
        echo $this->Form->input('id');   
		echo $this->Form->input('name', array('label'=>__('Name')));
		echo $this->Form->input('User', array('label'=>__('Users in this group<br/>Press \'Control\' for multi-selection'), 'style'=>'width: 15em;'));
	?>
	</fieldset>
<?php echo $this->Form->end(__('Modify'));?>
</div>
<div class="actions">
	<ul>
        <li class="icon info"><?php echo $this->Html->link(__('View group'), array('action'=>'view', $this->Form->value('Group.id')));?></li>
		<li class="icon cross"><?php echo $this->Html->link(__('Delete'), array('action'=>'delete', $this->Form->value('Group.id')), null, sprintf(__('Are you sure you want to delete # %s?'), $this->Form->value('Group.id'))); ?></li>
	</ul>
</div>
</div>
