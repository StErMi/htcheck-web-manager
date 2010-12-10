<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

	<div class="row">
		<?php echo $form->label($model,'IDServer'); ?>
		<?php echo $form->textField($model,'IDServer'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'Server'); ?>
		<?php echo $form->textField($model,'Server',array('size'=>60,'maxlength'=>255)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'IPAddress'); ?>
		<?php echo $form->textField($model,'IPAddress',array('size'=>15,'maxlength'=>15)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'Port'); ?>
		<?php echo $form->textField($model,'Port'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'HttpServer'); ?>
		<?php echo $form->textField($model,'HttpServer',array('size'=>60,'maxlength'=>255)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'HttpVersion'); ?>
		<?php echo $form->textField($model,'HttpVersion',array('size'=>60,'maxlength'=>255)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'PersistentConnection'); ?>
		<?php echo $form->textField($model,'PersistentConnection'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'Requests'); ?>
		<?php echo $form->textField($model,'Requests'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Search'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->