<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('IDUrl')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->IDUrl), array('view', 'id'=>$data->IDUrl)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('IDServer')); ?>:</b>
	<?php echo CHtml::encode($data->IDServer); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('Url')); ?>:</b>
	<?php echo CHtml::encode($data->Url); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('Status')); ?>:</b>
	<?php echo CHtml::encode($data->Status); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('Domain')); ?>:</b>
	<?php echo CHtml::encode($data->Domain); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('CreationTime')); ?>:</b>
	<?php echo CHtml::encode($data->CreationTime); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('IDReferer')); ?>:</b>
	<?php echo CHtml::encode($data->IDReferer); ?>
	<br />

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('HopCount')); ?>:</b>
	<?php echo CHtml::encode($data->HopCount); ?>
	<br />

	*/ ?>

</div>