<?php $this->Html->addCrumb('Users', $this->Html->url( null, true )); ?>
<div id="content">
	<div class="container">
		<div class="section">
			<div class="section-header">
				<h3>
					Users
					<small>
						<?php
						echo $this->Paginator->counter(array(
						'format' => __('There are %current% users on this system.')
						));
						?>
					</small>
				</h3>
				<div class="section-actions">
					<a href="<?php echo $this->Html->url(array('controller'=>'users','action'=>'add')); ?>" class="btn btn-primary">
						New User
					</a>
				</div>
			</div>
			<div class="section-body">
				<div class="well well-small">
					<div class="row-fluid">
						<div class="span6 pagination">
						    <ul>
							<?php echo $this->Paginator->prev('<<', array('tag' => 'li', 'disabledTag' => 'span'), null, array());?>
							<?php echo $this->Paginator->numbers(array('tag' => 'li', 'separator' => '', 'currentTag' => 'span', 'first' => 2, 'last' => 2, 'modulus' => 20, 'ellipsis' => '<li><span>...</span></li>'));?>
							<?php echo $this->Paginator->next('>>', array('tag' => 'li', 'disabledTag' => 'span'), null, array());?>
						    </ul>
						</div>
							<?php
						echo $this->Paginator->counter(array(
							'format' => __('<div class="span2">
								<div class="ac stat-block" style="margin-bottom:0">
									<h3>
										%current%
									</h3>
									<h6 class="stat-heading">
										Total Users
									</h6>
								</div>
							</div>
							<div class="span2">
								<div class="ac stat-block" style="margin-bottom:0">
									<h3>
										%page%
									</h3>
									<h6 class="stat-heading">
										Page Number
									</h6>
								</div>
							</div>
							<div class="span2">
								<div class="ac stat-block" style="margin-bottom:0">
									<h3>
										%pages%
									</h3>
									<h6 class="stat-heading">
										Total Pages
									</h6>
								</div>
							</div>')
							));
							?>
					</div>
					<div class="row-fluid">
						<div class="span12">
                            <ul class="nav nav-pills" style="margin-top:4px;margin-bottom:0">
                                <li class="active">

                                        <?php echo $this->Paginator->sort('id');?>

                                </li>
                                <li class="">

                                        <?php echo $this->Paginator->sort('login');?>

                                </li>
                                <li class="">

                                        <?php echo $this->Paginator->sort('email');?>

                                </li>
                                <li class="">

                                        <a href="#"><?php echo 'Group';?></a>

                                </li>
                                <li class="">

                                        <?php echo $this->Paginator->sort('created');?>
                    
                                </li>
                                <li class="">

                                        <?php echo $this->Paginator->sort(__('Disabled'), 'disable');?>
                                    
                                </li>
                            </ul>
                        </div>
                        
					</div>
				</div>
				<table class="table table-outer-bordered">
					<tbody>
						<?php
						$i = 0;
						foreach ($users as $user):
							$class = '';
							if ($i++ % 2 == 0) {
								$class = 'altrow';
							}

							// check if user account enables
							$exp = $user['User']['expire_account'];

							if ($user['User']['disable'] or ($exp != '0000-00-00' and $this->Time->fromString($exp) < time()))
								$class = " class=\"{$class} disabled\"";
							else
								$class = " class=\"{$class}\"";

							?>
						<tr>
							<td style="width:30px">
								<a href="<?php echo $this->Html->url( array('action'=>'view', $user['User']['id'])); ?>">
									<?php echo $this->Gravatar->get_gravatar($user['User']['email'],30,'','',true) ?>
								</a>
							</td>
							<td>
								<i class="picons-16-basic3-146">
								</i>
								<?php echo $user['User']['id']; ?>
							</td>
							<td>
									<?php echo $this->Html->link($user['User']['login'], array('action'=>'view', $user['User']['id'])); ?>
							</td>
							<td>
									<?php $email = $user['User']['email']; echo "<a href=\"mailto:{$email}\">{$email}</a>"; ?>
							</td>
							<td>
								<div class="muted">
									<?php //pr($user['Group']);
								$gr = (count($user['Group'])) ? array() : array(__('Guest'));     // Specify Guest group if lonely group
								foreach($user['Group'] as $k=>$group)
									$gr[] = $this->Html->link(__($group['name']), array('controller'=>'groups', 'action'=>'view', $group['id']),array('class'=>'label'));

								echo implode(' ', $gr); ?>
								</div>
								</td>
							<td>
								<?php echo $this->Time->format('d/m/Y', $user['User']['created']); ?>&nbsp;
							</td>
							<td>
								<?php if ($user['User']['disable']) echo '<span class="label label-important">Disabled</span>&nbsp;';

								$exp = $user['User']['expire_account'];
								if ($exp != '0000-00-00' and $this->Time->fromString($exp) < time()) echo '<span class="label label-warning">Expired</span>';
								?>
							</td>
							<td>
								<div class="btn-group">
									<a class="btn btn-mini dropdown-toggle" data-toggle="dropdown" href="#">
										<i class="icon-cog">
										</i>
										<span class="caret">
										</span>
									</a>
									<ul class="dropdown-menu pull-right">
										<li>
											<a href="<?php echo $this->Html->url(array('action'=>'edit', $user['User']['id'])); ?>">
												<i class="icon-pencil">
												</i>
												Edit
											</a>
										</li>
										<li>
											<a href="<?php echo $this->Html->url( array('action'=>'delete', $user['User']['id']))?>" data-confirm="WARNING: This will also delete all data related to userss.
											This cannot be undone.
											Are you sure you want to delete <?php echo $user['User']['login']; ?>?" data-disable-with="Deleting..." data-method="delete" rel="nofollow">
											<i class="icon-trash"> </i>
											Delete
										</a>
									</li>
								</ul>
							</div>
						</td>
					</tr>
					<?php endforeach; ?>
				</tbody>
			</table>
			<div class="form-actions">
				<a href="<?php echo $this->Html->url(array('controller'=>'users','action'=>'add')); ?>" class="btn btn-primary">
					New User
				</a>
			</div>
		</div>
	</div>
</div>
</div>
