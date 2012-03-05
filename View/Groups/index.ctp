<div id="authake">
<?php if (!$tableonly) { echo $this->element('gotoadminpage'); } ?>
<div class="groups index">
<?php if (!$tableonly) { ?>

<h2><?php echo __('Groups');?></h2>
<div class="actions">
    <ul>
        <li class="icon add"><?php echo $this->Html->link(__('New group'), array('action'=>'add')); ?></li>
    </ul>
</div>
<?php } ?>
<p class="paging_count">
<?php
echo $this->Paginator->counter(array(
'format' => __('There are %current% groups on this system.')
));
?></p>
<table class="listing" cellpadding="0" cellspacing="0">
<tr>
	<th><?php echo $this->Paginator->sort('name');?></th>
	<th class="actions"><?php echo __('Actions');?></th>
</tr>
<?php
$i = 0;
foreach ($groups as $group):
	$class = null;
	if ($i++ % 2 == 0) {
		$class = ' class="altrow"';
	}
?>
	<tr<?php echo $class;?>>
    <?php if ($group['Group']['id'] != 0) { ?>
		<td>
			<?php echo $this->Html->link($group['Group']['name'], array('action'=>'view', $group['Group']['id'])); ?>
		</td>
		<td class="actions">
			<?php echo $this->Htmlbis->iconlink('information', __('View'), array('action'=>'view', $group['Group']['id'])); ?>
			<?php echo $this->Htmlbis->iconlink('pencil', __('Edit'), array('action'=>'edit', $group['Group']['id'])); ?>
			<?php echo $this->Htmlbis->iconlink('cross', __('Delete'), array('action'=>'delete', $group['Group']['id']), null, sprintf(__('Are you sure you want to delete the group \'%s\'?'), $group['Group']['name'])); ?>
        </td>
    <?php } else { ?>
	</tr>
    <?php } ?>
<?php endforeach; ?>
<?php
    $class = null;
    if ($i++ % 2 == 0) {
        $class = ' class="altrow"';
    }
    echo "<tr{$class}>";
    ?>
        <td>
            <?php echo __('Everybody (all users, logged or not, are in this group)'); ?>
        </td>
        <td class="actions">&nbsp;
        </td>
    </tr>
</table>
</div>
</div>
