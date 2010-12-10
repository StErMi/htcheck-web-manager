<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('IDServer')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->IDServer), array('view', 'id'=>$data->IDServer)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('Server')); ?>:</b>
	<?php echo CHtml::encode($data->Server); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('IPAddress')); ?>:</b>
	<?php echo CHtml::encode($data->IPAddress); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('Port')); ?>:</b>
	<?php echo CHtml::encode($data->Port); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('HttpServer')); ?>:</b>
	<?php echo CHtml::encode($data->HttpServer); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('HttpVersion')); ?>:</b>
	<?php echo CHtml::encode($data->HttpVersion); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('PersistentConnection')); ?>:</b>
	<?php echo CHtml::encode($data->PersistentConnection); ?>
	<br />

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('Requests')); ?>:</b>
	<?php echo CHtml::encode($data->Requests); ?>
	<br />

	*/ ?>

</div>