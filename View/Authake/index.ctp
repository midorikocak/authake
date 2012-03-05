<div id="authake">
<?php echo $this->element('gotoadminpage'); ?>
    <div class="index">
        <h2><?php echo __('Authake administration page');?></h2>
    </div>
    <div class="index">
        <h3><?php echo __('Users');?></h3>
        <?php echo $this->requestAction('authake/users/index/tableonly', array('return')); ?>
        <div class="actions">
            <ul>
                <li class="icon add"><?php echo $this->Html->link(__('New user'), array('controller'=> 'users', 'action'=>'add')); ?></li>
            </ul>
        </div>
    </div>
    <div class="index">
        <h3><?php echo __('Groups');?></h3>
        <?php echo $this->requestAction('authake/groups/index/tableonly', array('return')); ?>
        <div class="actions">
            <ul>
                <li class="icon add"><?php echo $this->Html->link(__('New group'), array('controller'=> 'groups', 'action'=>'add')); ?></li>
            </ul>
        </div>
    </div>
    <div class="index">
        <h3><?php echo __('Rules');?></h3>
        <?php echo $this->requestAction('authake/rules/index/tableonly', array('return')); ?>
        <div class="actions">
            <ul>
                <li class="icon add"><?php echo $this->Html->link(__('New rule'), array('controller'=> 'rules', 'action'=>'add')); ?></li>
            </ul>
        </div>
    </div>
</div>
