<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

	<?php echo CHtml::hiddenField('_from_search'); ?>
	
	
	<h3>Search for URLs</h3>
	<div class="row">
		<?php echo $form->dropDownList($search,'url_name_type_1', UrlSearchForm::getUrlNameTypeList()); ?>
		<?php echo $form->textField($search,'url_name_text_1'); ?>
	</div>
	<div class="row">
		<?php echo $form->dropDownList($search,'url_name_type_2', UrlSearchForm::getUrlNameTypeList()); ?>
		<?php echo $form->textField($search,'url_name_text_2'); ?>
	</div>
	<div class="row">
		<?php echo $form->dropDownList($search,'url_name_type_3', UrlSearchForm::getUrlNameTypeList()); ?>
		<?php echo $form->textField($search,'url_name_text_3'); ?>
	</div>
	
	<div class="row">
		<?php echo $form->labelEx($search,'url_statuscode_type'); ?>
		<?php echo $form->dropDownList($search,'url_statuscode_type', UrlSearchForm::getUrlStatusCodeTypeList()); ?>
		<?php echo $form->dropDownList($search,'url_statuscode', $search->getUrlStatusCodeList()); ?>
	</div>
	
	<div class="row">
		<?php echo $form->labelEx($search,'url_contentype_type'); ?>
		<?php echo $form->dropDownList($search,'url_contentype_type', UrlSearchForm::getUrlContentypeTypeList()); ?>
		<?php echo $form->dropDownList($search,'url_contentype', $search->getUrlContentypeList() ); ?>
	</div>
	
	<div class="row">
		<?php echo $form->labelEx($search,'url_charset_type'); ?>
		<?php echo $form->dropDownList($search,'url_charset_type', UrlSearchForm::getUrlCharsetTypeList()); ?>
		<?php echo $form->dropDownList($search,'url_charset', $search->getUrlCharsetList() ); ?>
	</div>
	
	<div class="row">
		<?php echo $form->labelEx($search,'url_doctype_type'); ?>
		<?php echo $form->dropDownList($search,'url_doctype_type', UrlSearchForm::getUrlDoctypeTypeList()); ?>
		<?php echo $form->dropDownList($search,'url_doctype', $search->getUrlDoctypeList() ); ?>
	</div>
	
	<div class="row">
		<?php echo $form->labelEx($search,'url_size_type'); ?>
		<?php echo $form->dropDownList($search,'url_size_type', UrlSearchForm::getUrlSizeTypeList()); ?>
		<?php echo $form->textField($search,'url_size_text' ); ?> KBytes
	</div>
	
	<div class="row">
		<?php echo $form->labelEx($search,'url_sizeadd_type'); ?>
		<?php echo $form->dropDownList($search,'url_sizeadd_type', UrlSearchForm::getUrlSizeTypeList()); ?>
		<?php echo $form->textField($search,'url_sizeadd_text' ); ?> KBytes
	</div>
	<br /><br />
	<h3>Search for Page Title</h3>
	<div class="row">
		<?php echo $form->dropDownList($search,'url_title_type_1', UrlSearchForm::getUrlNameTypeList()); ?>
		<?php echo $form->textField($search,'url_title_text_1'); ?>
	</div>
	<div class="row">
		<?php echo $form->dropDownList($search,'url_title_type_2', UrlSearchForm::getUrlNameTypeList()); ?>
		<?php echo $form->textField($search,'url_title_text_2'); ?>
	</div>
	<div class="row">
		<?php echo $form->dropDownList($search,'url_title_type_3', UrlSearchForm::getUrlNameTypeList()); ?>
		<?php echo $form->textField($search,'url_title_text_3'); ?>
	</div>
	
	<h3>Search for Page Description</h3>
	<div class="row">
		<?php echo $form->dropDownList($search,'url_desc_type_1', UrlSearchForm::getUrlNameTypeList()); ?>
		<?php echo $form->textField($search,'url_desc_text_1'); ?>
	</div>
	<div class="row">
		<?php echo $form->dropDownList($search,'url_desc_type_2', UrlSearchForm::getUrlNameTypeList()); ?>
		<?php echo $form->textField($search,'url_desc_text_2'); ?>
	</div>
	<div class="row">
		<?php echo $form->dropDownList($search,'url_desc_type_3', UrlSearchForm::getUrlNameTypeList()); ?>
		<?php echo $form->textField($search,'url_desc_text_3'); ?>
	</div>
	
	<h3>Search for Page Keywords</h3>
	<div class="row">
		<?php echo $form->dropDownList($search,'url_key_type_1', UrlSearchForm::getUrlNameTypeList()); ?>
		<?php echo $form->textField($search,'url_key_text_1'); ?>
	</div>
	<div class="row">
		<?php echo $form->dropDownList($search,'url_key_type_2', UrlSearchForm::getUrlNameTypeList()); ?>
		<?php echo $form->textField($search,'url_key_text_2'); ?>
	</div>
	<div class="row">
		<?php echo $form->dropDownList($search,'url_key_type_3', UrlSearchForm::getUrlNameTypeList()); ?>
		<?php echo $form->textField($search,'url_key_text_3'); ?>
	</div>
	
	

	<div class="row buttons">
		<?php echo CHtml::submitButton('Search'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->