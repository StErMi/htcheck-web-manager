<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

	<?php echo CHtml::hiddenField('_from_search'); ?>

	<div class="row">
		<?php echo $form->labelEx($search,'result_type'); ?>
		<?php echo $form->dropDownList($search,'result_type', LinkSearchForm::getSmallTypeList()); ?>
		<?php echo $form->dropDownList($search,'result', $search->getResultList()); ?>
	</div>
	
	<div class="row">
		<?php echo $form->labelEx($search,'linktype_type'); ?>
		<?php echo $form->dropDownList($search,'linktype_type', LinkSearchForm::getSmallTypeList()); ?>
		<?php echo $form->dropDownList($search,'linktype', $search->getLinktypeList()); ?>
	</div>
	
	<div class="row">
		<?php echo $form->labelEx($search,'linkdomain_type'); ?>
		<?php echo $form->dropDownList($search,'linkdomain_type', LinkSearchForm::getSmallTypeList()); ?>
		<?php echo $form->dropDownList($search,'linkdomain', $search->getLinkdomainList()); ?>
	</div>
	
	<h3>Referencing URL</h3>
	<div class="row">
		<?php echo $form->dropDownList($search,'referencing_url_type_1', LinkSearchForm::getFullTypeList()); ?>
		<?php echo $form->textField($search,'referencing_url_text_1'); ?>
	</div>
	<div class="row">
		<?php echo $form->dropDownList($search,'referencing_url_type_2', LinkSearchForm::getFullTypeList()); ?>
		<?php echo $form->textField($search,'referencing_url_text_2'); ?>
	</div>
	<div class="row">
		<?php echo $form->dropDownList($search,'referencing_url_type_3', LinkSearchForm::getFullTypeList()); ?>
		<?php echo $form->textField($search,'referencing_url_text_3'); ?>
	</div>
	
	<h3>Referenced URL</h3>
	<div class="row">
		<?php echo $form->dropDownList($search,'referenced_url_type_1', LinkSearchForm::getFullTypeList()); ?>
		<?php echo $form->textField($search,'referenced_url_text_1'); ?>
	</div>
	<div class="row">
		<?php echo $form->dropDownList($search,'referenced_url_type_2', LinkSearchForm::getFullTypeList()); ?>
		<?php echo $form->textField($search,'referenced_url_text_2'); ?>
	</div>
	<div class="row">
		<?php echo $form->dropDownList($search,'referenced_url_type_3', LinkSearchForm::getFullTypeList()); ?>
		<?php echo $form->textField($search,'referenced_url_text_3'); ?>
	</div>
	
	<h3>Anchor</h3>
	<div class="row">
		<?php echo $form->dropDownList($search,'anchor_type_1', LinkSearchForm::getFullTypeList()); ?>
		<?php echo $form->textField($search,'anchor_text_1'); ?>
	</div>
	<div class="row">
		<?php echo $form->dropDownList($search,'anchor_type_2', LinkSearchForm::getFullTypeList()); ?>
		<?php echo $form->textField($search,'anchor_text_2'); ?>
	</div>
	<div class="row">
		<?php echo $form->dropDownList($search,'anchor_type_3', LinkSearchForm::getFullTypeList()); ?>
		<?php echo $form->textField($search,'anchor_text_3'); ?>
	</div>
	
	<div class="row buttons">
		<?php echo CHtml::submitButton('Search'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->