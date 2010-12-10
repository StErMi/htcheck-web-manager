<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('IDCookie')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->IDCookie), array('view', 'id'=>$data->IDCookie)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('Name')); ?>:</b>
	<?php echo CHtml::encode($data->Name); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('Value')); ?>:</b>
	<?php echo CHtml::encode($data->Value); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('Path')); ?>:</b>
	<?php echo CHtml::encode($data->Path); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('Domain')); ?>:</b>
	<?php echo CHtml::encode($data->Domain); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('MaxAge')); ?>:</b>
	<?php echo CHtml::encode($data->MaxAge); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('Version')); ?>:</b>
	<?php echo CHtml::encode($data->Version); ?>
	<br />

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('SrcUrl')); ?>:</b>
	<?php echo CHtml::encode($data->SrcUrl); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('Expires')); ?>:</b>
	<?php echo CHtml::encode($data->Expires); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('Secure')); ?>:</b>
	<?php echo CHtml::encode($data->Secure); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('DomainValid')); ?>:</b>
	<?php echo CHtml::encode($data->DomainValid); ?>
	<br />

	*/ ?>

</div>