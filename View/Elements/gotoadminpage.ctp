<div class="actions menuheader">
    <ul>
        <li class="icon door_in"><?php echo $this->Html->link(__('Homepage'), '/'); ?></li>
        <li class="icon house"><?php echo $this->Html->link(__('Admin page'), array('controller'=> 'authake', 'action'=>'index')); ?></li>
        <li class="icon door_in"><?php echo $this->Html->link(__('Logout'), array('controller'=> 'user', 'action'=>'logout')); ?></li>
        <li>&nbsp;</li>
        <li class="icon user"><?php echo $this->Html->link(__('Manage users'), array('controller'=> 'users', 'action'=>'index')); ?> </li>
        <li class="icon group"><?php echo $this->Html->link(__('Manage groups'), array('controller'=> 'groups', 'action'=>'index')); ?> </li>
        <li class="icon lock"><?php echo $this->Html->link(__('Manage rules'), array('controller'=> 'rules', 'action'=>'index')); ?> </li>
    </ul>
</div>

