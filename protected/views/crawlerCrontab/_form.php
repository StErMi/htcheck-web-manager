
<?php if ( isset($model2) ): ?>
<div class="form">

<?php $form1=$this->beginWidget('CActiveForm', array(
	'id'=>'crawler-crontab-form',
	'enableAjaxValidation'=>false,
)); ?>
	
	<?php echo CHtml::hiddenField('manual', 'true'); ?>
	<?php echo $form1->hiddenField( $model2, 'user_id'); ?>
	<fieldset class="ui-widget ui-widget-content ui-corner-all"> 
	<legend class="ui-widget ui-widget-header ui-corner-all">Add new scan to Queue ( Manual )</legend> 
	
	<p>This action will add a new scan to the Crawler Queue. The new scan will be done as soon as possible and the results will update the crawler informations!</p>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Add scan!'); ?>
	</div>
	
	</fieldset>

<?php $this->endWidget(); ?>

</div><!-- form -->


<br />
<?php endif; ?>
<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'crawler-crontab-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>
	
	<fieldset class="ui-widget ui-widget-content ui-corner-all"> 
	<legend class="ui-widget ui-widget-header ui-corner-all">Create Crawler Cron (Programmed Scan)</legend> 

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model, 'minute'); ?>
		<?php echo $form->dropDownList( $model, 'minute', CrawlerCrontab::getMinuteList() ); ?>
		<?php echo $form->error( $model,'minute'); ?>
	</div>
	
	<div class="row">
		<?php echo $form->labelEx($model, 'hour'); ?>
		<?php echo $form->dropDownList( $model, 'hour', CrawlerCrontab::getHourList() ); ?>
		<?php echo $form->error( $model,'hour'); ?>
	</div>
	
	<div class="row">
		<?php echo $form->labelEx($model, 'day'); ?>
		<?php echo $form->dropDownList( $model, 'day', CrawlerCrontab::getDayList() ); ?>
		<?php echo $form->error( $model,'day'); ?>
	</div>
	
	<div class="row">
		<?php echo $form->labelEx($model, 'month'); ?>
		<?php echo $form->dropDownList( $model, 'month', CrawlerCrontab::getMonthList() ); ?>
		<?php echo $form->error( $model,'month'); ?>
	</div>
	
	<div class="row">
		<?php echo $form->labelEx($model, 'weekday'); ?>
		<?php echo $form->dropDownList( $model, 'weekday', CrawlerCrontab::getWeekDayList() ); ?>
		<?php echo $form->error( $model,'weekday'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>
	
	</fieldset>

<?php $this->endWidget(); ?>

</div><!-- form -->
