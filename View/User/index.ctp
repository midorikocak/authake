<div id="content">
	<div class="container">
		<div class="section">
			<div class="section-header">
				<h3><?php  echo __('Profile of '); echo $user['User']['login'];?></h3>
			</div>
			<div class="section-body">
				<div class="row-fluid">
					<div class="span2">
						<?php
						if(!empty($contact['Mail']))
						{
						 echo $this->Authake->Gravatar->get_gravatar($this->Authake->getUserMail(),130,'','',true);
						}
						?>
					</div>
					<div class="span10">
						<div class="page-header">
							<h3><?php echo __('User Information');?></h3>
						</div>
						<table class="table table-outer-bordered table-striped">
							<tbody>
								<tr>
								<th class="span3"><?php echo __('Login');?></th>
								<td><?php echo $user['User']['login']." <em>(ID {$user['User']['id']})</em>"; ?></td>
							</tr>
								<tr>
								<th>Groups</th>
								<td>
									<?php
									if(!empty($user['Group']))
									{
									?>
									<div class="muted">
										<?php //pr($user['Group']);
									$gr = (count($user['Group'])) ? array() : array(__('Groups'));     // Specify Guest group if lonely group
									foreach($user['Group'] as $group)
										$gr[] = __($group['name']);
										if (empty($gr))
							                echo __('Guest');
							            else
							                echo implode(" ", $gr); ?>
									</div>
									<?php
									}
									?>
								</td>
							</tr>
								<tr>
								<th><?php echo __('Created');?></th>
								<td colspan="2"><?php echo $this->Time->format('d/m/Y H:i', $this->Time->fromString($user['User']['created'])); ?></td>
							</tr>
							</tbody>
						</table>
						<div class="well well-small">
							<?php echo $this->Form->create('User', array('url' => array('controller' => 'user', 'action'=>'index')));?>
							<fieldset>
						        <legend><?php echo __('Modify profile');?></legend>
						    	<?php
						        echo $this->Form->input('email', array('value'=>$user['User']['email'], 'size'=>'40', 'after'=>'<p>'.__('(If modified, you will have to confirm it before the next login)').'</p>'));
						        echo $this->Form->input('password1', array('type'=>'password', 'label'=> __('New Password') , 'value' => '', 'size'=>'12'));
						        echo $this->Form->input('password2', array('type'=>'password',  'label'=> __('Enter Your New Password Again'), 'value' => '', 'size'=>'12'));
						    	?>
							</fieldset>
								<?php echo $this->Form->end(array('div'=>false,'label'=>'Save','class'=>'action input-action btn btn-success'));?>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
