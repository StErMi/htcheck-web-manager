<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

	<h3>Search for URL</h3>
	
	<div class="row">
		<?php echo $form->labelEx($search,'domain'); ?>
		<?php echo $form->dropDownList($search,'domain', $search->getDomainList(), array( 'empty'=>'--- Select a server ---') ); ?>
	</div>
	
	<div class="row">
		<?php echo $form->dropDownList($search,'url_name_type_1', AccessibilitySearchForm::getFullTypeList()); ?>
		<?php echo $form->textField($search,'url_name_text_1'); ?>
	</div>
	<div class="row">
		<?php echo $form->dropDownList($search,'url_name_type_2', AccessibilitySearchForm::getFullTypeList()); ?>
		<?php echo $form->textField($search,'url_name_text_2'); ?>
	</div>
	<div class="row">
		<?php echo $form->dropDownList($search,'url_name_type_3', AccessibilitySearchForm::getFullTypeList()); ?>
		<?php echo $form->textField($search,'url_name_text_3'); ?>
	</div>
	
	<div class="row">
		<?php echo $form->labelEx($search,'doctype_type'); ?>
		<?php echo $form->dropDownList($search,'doctype_type', AccessibilitySearchForm::getSmallTypeList()); ?>
		<?php echo $form->dropDownList($search,'doctype', $search->getDoctypeList() ); ?>
	</div>
	
	<div class="row">
		<?php echo $form->labelEx($search,'errorcode'); ?>
		<?php echo $form->checkBoxList($search,'errorcode', $search->getErrorcodeList() ); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Search'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->