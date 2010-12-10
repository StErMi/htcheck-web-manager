<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

	<div class="row">
		<?php echo $form->label($model,'IDCookie'); ?>
		<?php echo $form->textField($model,'IDCookie'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'Name'); ?>
		<?php echo $form->textField($model,'Name',array('size'=>60,'maxlength'=>255)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'Value'); ?>
		<?php echo $form->textArea($model,'Value',array('rows'=>6, 'cols'=>50)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'Path'); ?>
		<?php echo $form->textField($model,'Path',array('size'=>60,'maxlength'=>255)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'Domain'); ?>
		<?php echo $form->textField($model,'Domain',array('size'=>60,'maxlength'=>255)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'MaxAge'); ?>
		<?php echo $form->textField($model,'MaxAge'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'Version'); ?>
		<?php echo $form->textField($model,'Version'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'SrcUrl'); ?>
		<?php echo $form->textField($model,'SrcUrl',array('size'=>60,'maxlength'=>255)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'Expires'); ?>
		<?php echo $form->textField($model,'Expires'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'Secure'); ?>
		<?php echo $form->textField($model,'Secure'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'DomainValid'); ?>
		<?php echo $form->textField($model,'DomainValid'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Search'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->