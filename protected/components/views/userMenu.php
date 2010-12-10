<?php $u = User::getMe(); ?>
<ul class="operations">
	<li><?php echo CHtml::link('Update Profile',array('user/update', 'id'=>$u->id)); ?></li>
	<li><?php echo CHtml::link('View Profile',array('user/view', 'id'=>$u->id)); ?></li>
</ul>