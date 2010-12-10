<ul class="operations">
	<?php if ( $full ): ?>
	<li><?php echo CHtml::link('Create User',array('user/create')); ?></li>
	<li><?php echo CHtml::link('Manage Users',array('user/admin')); ?></li>
	<li><?php echo CHtml::link('Create Crawler',array('crawler/create')); ?></li>
	<li><?php echo CHtml::link('Manage Crawlers',array('crawler/admin')); ?></li>
	<li><?php echo CHtml::link('Create Group',array('group/create')); ?></li>
	<li><?php echo CHtml::link('Manage Group',array('group/admin')); ?></li>
	<?php else: ?>
	<li><?php echo CHtml::link('Manage Crawlers',array('crawler/admin')); ?></li>
	<?php endif; ?>
</ul>
