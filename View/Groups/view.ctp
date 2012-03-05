<div id="authake">
<div class="actions menuheader">
    <ul>
        <li class="icon group"><?php echo $this->Html->link(__('Manage groups'), array('action'=>'index'));?></li>
    </ul>
</div>
<div class="groups view">
<h2><?php  echo sprintf(__('Group %s'), "<u>{$group['Group']['name']}</u>"); ?></h2>
</div>
<div class="actions">
	<ul>
<?php if (!empty($actions)) { ?>
        <li class="icon group"><?php echo $this->Html->link(__('View group'), array('action'=>'view', $group['Group']['id'])); ?></li>
<?php } ?>
		<li class="icon group_edit"><?php echo $this->Html->link(__('Edit group'), array('action'=>'edit', $group['Group']['id'])); ?></li>
<?php if (empty($actions)) { ?>
        <li class="icon lock"><?php echo $this->Html->link(__('View allowed & denied actions'), array('action'=>'view', $group['Group']['id'] ,'actions')); ?></li>
        <li class="icon cross"><?php echo $this->Html->link(__('Delete group'), array('action'=>'delete', $group['Group']['id']), null, sprintf(__('Are you sure you want to delete the group %s?'), $group['Group']['id'])); ?></li>
<?php } ?>  
	</ul>
</div>

<?php if (!empty($actions)) { ?>

<div class="monitor_rules index">
<h3><?php __('Allowed & denied actions');?></h3>
<?php
    foreach($actions as $controller => $ruleslist) {
        echo "<div style=\"float: left; padding: 0 0.7em; margin: 0.5em; border-left: 1px solid #CCC;\"><h4>{$controller}</h4>";
        echo "<ul>";
        foreach($ruleslist as $k => $rule) {
            if ($rule['permission'] == "Allow")
                echo '<li class="icon accept"><p style="color: green">'.$rule['action'];
            else
                echo '<li class="icon delete"><p style="color: red">'.$rule['action'];
            echo '</p></li>';
        
        }
        echo "</ul></div>";
    }

?>
<p style="clear: both"></p>
</div>
    <div class="actions">
        <ul>
            <li class="icon lock"><?php echo $this->Html->link(__('Manage rules'), array('controller'=> 'rules', 'action'=>'index')); ?></li>
            <li class="icon accept"><?php echo $this->Html->link(__('Hide this view'), array('action'=>'view', $group['Group']['id'])); ?></li>
        </ul>
    </div>
<?php } ?>

<div class="related">
    <h3><?php echo sprintf(__('Users in group %s'), $group['Group']['name']);?></h3>
    <?php if (!empty($group['User'])):?>
    <table class="listing" cellpadding = "0" cellspacing = "0">
    <tr>
        <th><?php echo __('Login'); ?></th>
        <th><?php echo __('Email'); ?></th>
        <th class="actions"><?php __('Actions');?></th>
    </tr>
    <?php
        $i = 0;
        foreach ($group['User'] as $user):
            $class = null;
            if ($i++ % 2 == 0) {
                $class = ' class="altrow"';
            }
        ?>
        <tr<?php echo $class;?>>
            <td><?php echo $this->Html->link($user['login'], array('controller'=> 'users', 'action'=>'view', $user['id']));?></td>
            <td><?php echo $user['email'];?></td>
            <td class="actions">
                <?php echo $this->Htmlbis->iconlink('information', __('View'), array('controller'=> 'users', 'action'=>'view', $user['id'])); ?>
                <?php echo $this->Htmlbis->iconlink('pencil', __('Edit'), array('controller'=> 'users', 'action'=>'edit', $user['id'])); ?>
            </td>
        </tr>
    <?php endforeach; ?>
    </table>
<?php endif; ?>

    <div class="actions">
        <ul>
            <li class="icon user"><?php echo $this->Html->link(__('Manage users'), array('controller'=> 'users', 'action'=>'index')); ?> </li>
        </ul>
    </div>
</div>





<div class="related">
	<h3><?php echo sprintf(__('Rules applied to the group %s'), $group['Group']['name']);?></h3>
<?php if (!empty($rules)) { ?>
    <p><em><?php __('Rules herited from guest group are greyed'); ?></em></p>
	<table class="listing" cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php __('Description'); ?></th>
		<th>&nbsp;</th>
		<th><?php __('Action'); ?></th>
		<th class="actions"><?php __('Actions');?></th>
	</tr>
    <?php
        $i = 0;
        foreach ($rules as $rule):
            $rule = $rule['Rule'];
            $class = null;
            if ($i++ % 2 == 0) {
                $class = ' class="altrow"';
            }
        ?>
        <tr<?php echo $class;?><?php
        if ($rule['group_id'] != 0)
            echo " style=\"font-weight: bold;\"";
        else
                echo " style=\"color: #999;\"";
         ?>>
            <td><?php echo $rule['name'];?></td>
            <td><?php echo $this->Htmlbis->iconallowdeny($rule['permission']); ?></td>
            <td><?php
             echo str_replace(' or ', '<br/>', $rule['action']);
             ?></td>
            <td class="actions">
                <?php echo $this->Htmlbis->iconlink('information', __('View'), array('controller'=> 'rules', 'action'=>'view', $rule['id'])); ?>
                <?php echo $this->Htmlbis->iconlink('pencil', __('Edit'), array('controller'=> 'rules', 'action'=>'edit', $rule['id'])); ?>
            </td>
        </tr>
    <?php endforeach; ?>
	</table>
<?php } else { ?>
    <p>No rule for this group.</p>
<?php } ?>

	<div class="actions">
		<ul>
            <li class="icon add"><?php echo $this->Html->link(__('New rule'), array('controller'=> 'rules', 'action'=>'add')); ?> </li>
            <li class="icon lock"><?php echo $this->Html->link(__('Manage rules'), array('controller'=> 'rules', 'action'=>'index')); ?> </li>
            
		</ul>
	</div>
</div>
</div>
