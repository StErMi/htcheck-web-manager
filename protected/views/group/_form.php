
<?php Yii::app()->clientScript->registerCssFile( Yii::app()->request->baseUrl . '/css/greed_styles.css' ); ?>

<style type="text/css">
td.text-center{
text-align: center;
}
</style> 

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'group-form',
	'enableAjaxValidation'=>false,
)); ?>
	<fieldset class="ui-widget ui-widget-content ui-corner-all"> 
	<legend class="ui-widget ui-widget-header ui-corner-all"><?php echo $formLegend; ?></legend> 

	<p class="note">Fields with <span class="required">*</span> are required.</p>
	

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'title'); ?>
		<?php echo $form->textField($model,'title',array('size'=>60,'maxlength'=>100)); ?>
		<?php echo $form->error($model,'title'); ?>
	</div>
	
	
	
	<div class="grid-view" id="group-grid">
	<table class="items">
	<thead>
	<tr>
	<th>Crawler Name</th><th>Can read?</th><th>Can edit config?</th><th>Can manage scans?</th><th>Is admin?</th>
	</tr>
	
	</thead>
	<tbody>
	<?php foreach($cgArray as $i => $cg): ?>
	<tr class="<?php echo ($i%2==0)?'odd':'even'; ?>">
		<td><font color="green"><b><?php echo $clTitle[$i]; ?></b></font></td>
		<td class="text-center"><?php echo CHtml::activeLabelEx($cg,'read', array('style'=>'display: none;')); ?><?php echo CHtml::activeCheckBox($cg, "read", array('name'=>"GroupCrawler[read][$i]")); ?></td>
		<td class="text-center"><?php echo CHtml::activeLabelEx($cg,'config', array('style'=>'display: none;')); ?><?php echo CHtml::activeCheckBox($cg, "config", array('name'=>"GroupCrawler[config][$i]")); ?></td>
		<td class="text-center"><?php echo CHtml::activeLabelEx($cg,'cron', array('style'=>'display: none;')); ?><?php echo CHtml::activeCheckBox($cg, "cron", array('name'=>"GroupCrawler[cron][$i]")); ?></td>
		<td class="text-center"><?php echo CHtml::activeLabelEx($cg,'admin', array('style'=>'display: none;')); ?><?php echo CHtml::activeCheckBox($cg, "admin", array('name'=>"GroupCrawler[admin][$i]")); ?></td>
	</tr>
	<?php endforeach; ?>
	</tbody>
	</table>
	</div>


	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>
	</fieldset>

<?php $this->endWidget(); ?>

</div><!-- form -->

