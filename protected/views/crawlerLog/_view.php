<div class="view">

	<font color="green">
	<b>LOG ID #<?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)); ?>
	<br /><br />
	</font>
	
	<b>Crawler:</b>
	<?php echo CHtml::encode($data->crawler->title); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('version')); ?>:</b>
	<?php echo CHtml::encode($data->version); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('start_time')); ?>:</b>
	<?php echo CHtml::encode($data->start_time); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('end_time')); ?>:</b>
	<?php echo CHtml::encode($data->end_time); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('scheduled_urls')); ?>:</b>
	<?php echo CHtml::encode($data->scheduled_urls); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('tot_urls')); ?>:</b>
	<?php echo CHtml::encode($data->tot_urls); ?>
	<br />
	
	<b><?php echo CHtml::encode($data->getAttributeLabel('retrieved_urls')); ?>:</b>
	<?php echo CHtml::encode($data->retrieved_urls); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('user')); ?>:</b>
	<?php echo CHtml::encode($data->user); ?>
	<br />

</div>