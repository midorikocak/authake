<div id="authake">
<div class="actions menuheader">
    <ul>
        <li class="icon lock"><?php echo $this->Html->link(__('Manage rules'), array('action'=>'index'));?></li>
    </ul>
</div>
<div class="rules view">
<h2><?php  echo __('Rule');?></h2>
	<dl><?php $i = 0; $class = ' class="altrow"';?>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __('Description'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $rule['Rule']['name']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __('Group'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php
             
            if (!$rule['Group']['id'])
                echo "<strong>".__("Everybody, including not logged users")."</strong>";
            else
                echo $this->Html->link($rule['Group']['name'], array('controller'=> 'groups', 'action'=>'view', $rule['Group']['id'])); ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __('Order'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $rule['Rule']['order']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __('Action'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php
             echo str_replace(' or ', '<br/>', $rule['Rule']['action']);
             ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __('Permission'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
            <?php
            echo $this->Htmlbis->iconallowdeny($rule['Rule']['permission']);
             ?>
			&nbsp;
		</dd>
        <dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __('Forward action on deny'); ?></dt>
        <dd<?php if ($i++ % 2 == 0) echo $class;?>>
            <?php
            $fw = $rule['Rule']['forward'];
            if ($fw)
                echo $fw;
            else
                echo __('Forward to the login page, or default deny action if logged');
?>
            &nbsp;
        </dd>
        <dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __('Flash message on deny'); ?></dt>
        <dd<?php if ($i++ % 2 == 0) echo $class;?>>
            <?php
            $msg = $rule['Rule']['message'];
            if ($msg)
                echo $msg;
            else
                echo __('No output');
?>
            &nbsp;
        </dd>
	</dl>
</div>
<div class="actions">
	<ul>
		<li class="icon lock_edit"><?php echo $this->Html->link(__('Edit Rule'), array('action'=>'edit', $rule['Rule']['id'])); ?> </li>
		<li class="icon cross"><?php echo $this->Html->link(__('Delete Rule'), array('action'=>'delete', $rule['Rule']['id']), null, sprintf(__('Are you sure you want to delete # %s?'), $rule['Rule']['id'])); ?> </li>
	</ul>
</div>
</div>