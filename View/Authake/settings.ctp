<?php
$this->Html->addCrumb('Authake Settings', $this->Html->url( null, true )); ?>
<div id="content">
	<div class="container">
		<div class="section">
			<div class="section-header">
				<h3>Authake Settings</h3>
				<div class="section-actions">
					<a href="<?php echo $this->Html->url( array('controller'=> 'authake', 'action'=>'index')); ?>" class="btn btn-primary">Cancel</a>
					<?php echo $this->Html->link(__('Reset Authake'), array('controller'=>'authake','action'=>'reset'), array('class'=>'btn btn-danger'),'Are you sure you want to reset Authake settings?'); ?>
				</div>
			</div>
			<div class="section-body">
				<?php echo $this->Form->create('Settings');?>
				<div class="form-horizontal">
					<fieldset class="inputs">
						<legend>Authake Settings</legend>
						<div class="string control-group stringish" id="baseUrl">
							<?php echo $this->Form->input('baseUrl', array('value'=>$configs['baseUrl'],'type'=>'text','label'=>array('text'=>__('Base URL'),'class'=>'control-label'),'between'=>'<div class="controls">', 'after'=>'<span class="help-inline">Base URL, used to insert the application URL in mails.</span></div>'));?>
						</div>
						<div class="string control-group stringish" id="service">
							<?php echo $this->Form->input('service', array('value'=>$configs['service'],'type'=>'text','label'=>array('text'=>__('Service'),'class'=>'control-label'),'between'=>'<div class="controls">', 'after'=>'<span class="help-inline">Name of the service i.e. "Super Authake"</span></div>'));?>
						</div>
						<div class="string control-group stringish" id="loginAction">
							<?php echo $this->Form->input('loginAction', array('value'=>Router::url($configs['loginAction']+ array("base" => false)),'type'=>'text','label'=>array('text'=>__('Login Action'),'class'=>'control-label'),'between'=>'<div class="controls">', 'after'=>'<span class="help-inline">Default login action</span></div>'));?>
						</div>
						<div class="string control-group stringish" id="loggedAction">
							<?php echo $this->Form->input('loggedAction', array('value'=>$configs['loggedAction'],'type'=>'text','label'=>array('text'=>__('Logged Action'),'class'=>'control-label'),'between'=>'<div class="controls">', 'after'=>'<span class="help-inline">Used to redirect the users if the current user is logged out. Basically, this is used in case when The login page is the home page. If this is not set to different location, then it\'s going into recursion.</span></div>'));?>
						</div>
						<div class="string control-group stringish" id="sessionTimeout">
							<?php echo $this->Form->input('sessionTimeout', array('value'=>$configs['sessionTimeout'],'type'=>'number','label'=>array('text'=>__('Session Timeout'),'class'=>'control-label'),'between'=>'<div class="controls">', 'after'=>'<span class="help-inline">Session timeout in seconds, if managed by Authake (or null to disable)</span></div>'));?>
						</div>
						<div class="string control-group stringish" id="defaultDeniedAction">
							<?php echo $this->Form->input('defaultDeniedAction', array('value'=>Router::url($configs['defaultDeniedAction']+ array("base" => false)),'type'=>'text','label'=>array('text'=>__('Default Denied Action'),'class'=>'control-label'),'between'=>'<div class="controls">', 'after'=>'<span class="help-inline">Default page when access is denied (should be allowed by ACLs...)</span></div>'));?>
						</div>
						<div class="string control-group stringish" id="rulesCacheTimeout">
							<?php echo $this->Form->input('rulesCacheTimeout', array('value'=>$configs['rulesCacheTimeout'],'type'=>'number','label'=>array('text'=>__('Rules Cache Timeout'),'class'=>'control-label'),'between'=>'<div class="controls">', 'after'=>'<span class="help-inline">Reload all rules every x seconds</span></div>'));?>
						</div>
						<div class="string control-group stringish" id="systemEmail">
							<?php echo $this->Form->input('systemEmail', array('value'=>$configs['systemEmail'],'type'=>'text','label'=>array('text'=>__('System Email'),'class'=>'control-label'),'between'=>'<div class="controls">', 'after'=>'<span class="help-inline">Email which sends the system mails</span></div>'));?>
						</div>
						<div class="string control-group stringish" id="systemReplyTo">
							<?php echo $this->Form->input('systemReplyTo', array('value'=>$configs['systemReplyTo'],'type'=>'text','label'=>array('text'=>__('System Reply To'),'class'=>'control-label'),'between'=>'<div class="controls">', 'after'=>'<span class="help-inline">Email which sends the system mails (Reply To)</span></div>'));?>
						</div>
						<div class="string control-group stringish" id="passwordVerify">
							<div class="controls">
									<label class="checkbox">
											<?php 
											if($configs['passwordVerify'])
											{
												echo $this->Form->checkbox('passwordVerify', array('value'=>$configs['passwordVerify'], 'checked'=>'checked'));
											}
											else
											{
												echo $this->Form->checkbox('passwordVerify', array('value'=>$configs['passwordVerify']));
											}
										?> Password Verify
								</label>
								<span class="help-inline">User need to authenticate that he requested the password change (by receiving the confirmation link at his e-mail)</span>
							</div>
						</div>
						<div class="string control-group stringish" id="registration">
							<div class="controls">
									<label class="checkbox">
										<?php 
										if($configs['registration'])
										{
											echo $this->Form->checkbox('registration', array('value'=>$configs['registration'], 'checked'=>'checked'));
										}
										else
										{
											echo $this->Form->checkbox('registration', array('value'=>$configs['registration']));
										}
									?> Users can register
								</label>
							</div>
						</div>
						<div class="string control-group stringish" id="defaultGroup">
							<?php echo $this->Form->input('defaultGroup', array('value'=>$configs['defaultGroup'],'type'=>'number','label'=>array('text'=>__('Default Group'),'class'=>'control-label'),'between'=>'<div class="controls">', 'after'=>'<span class="help-inline">Default group for registered users If set registered user will be inserted into specified group</span></div>'));?>
						</div>
						<div class="string control-group stringish" id="useDefaultLayout">
							<div class="controls">
									<label class="checkbox">
										<?php 
										if($configs['useDefaultLayout'])
										{
											echo $this->Form->checkbox('useDefaultLayout', array('value'=>$configs['useDefaultLayout'], 'checked'=>'checked'));
										}
										else
										{
											echo $this->Form->checkbox('useDefaultLayout', array('value'=>$configs['useDefaultLayout']));
										}
									?> Use default layout
								</label>
								<span class="help-inline">Skip using authake layout for User controller. This is used to display default layout of the application to actions like login, register, change password etc.</span>
							</div>
						</div>
						<div class="string control-group stringish" id="useEmailAsUsername">
							<div class="controls">
									<label class="checkbox">
									<?php 
									if($configs['useEmailAsUsername'])
									{
										echo $this->Form->checkbox('useEmailAsUsername', array('value'=>$configs['useEmailAsUsername'], 'checked'=>'checked'));
									}
									else
									{
										echo $this->Form->checkbox('useEmailAsUsername', array('value'=>$configs['useEmailAsUsername']));
									}
								?> Use Email as Username
								</label>
								<span class="help-inline">Use only email instead of user/email (a lot of sites are using this behavior, i.e.: Google, so people is already used to it) Defaults to false so it keeps on the old behavior</span>
							</div>
						</div>
					</fieldset>
					<fieldset class="form-actions">
						<?php echo $this->Form->end(array('div'=>false,'label'=>'Save','class'=>'action input-action btn btn-primary'));?>
						<a href="<?php echo $this->Html->url( array('controller'=> 'authake', 'action'=>'index')); ?>" class="btn btn-link">Cancel</a>
					</fieldset>
				</div>
			</div>
		</div>
	</div>
</div>