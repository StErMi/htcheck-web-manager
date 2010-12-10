<div class="view">
	<b><?php echo CHtml::encode($data->getAttributeLabel('StartTime')); ?>:</b>
	<?php echo CHtml::encode($data->StartTime); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('EndTime')); ?>:</b>
	<?php echo CHtml::encode($data->EndTime); ?>
	<br />
	
	<b><?php echo CHtml::encode($data->getAttributeLabel('User')); ?>:</b>
	<?php echo CHtml::encode($data->User); ?>
	<br />
	
	<b><?php echo CHtml::encode('Server'); ?>:</b>
	<?php echo CHtml::encode($db_info['Server']); ?>
	<br />
	
	<b><?php echo CHtml::encode('Schedule'); ?>:</b>
	<?php echo CHtml::encode($db_info['Schedule']); ?>
	<br />
	
	<b><?php echo CHtml::encode('Url'); ?>:</b>
	<?php echo CHtml::encode($db_info['Url']); ?>
	<br />
	
	<b><?php echo CHtml::encode('HtmlStatement'); ?>:</b>
	<?php echo CHtml::encode($db_info['HtmlStatement']); ?>
	<br />
	
	<b><?php echo CHtml::encode('HtmlAttribute'); ?>:</b>
	<?php echo CHtml::encode($db_info['HtmlAttribute']); ?>
	<br />
	
	<b><?php echo CHtml::encode('Link'); ?>:</b>
	<?php echo CHtml::encode($db_info['Link']); ?>
	<br />
</div>