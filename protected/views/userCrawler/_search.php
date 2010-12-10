<?php 

$userOptions2 = array(
	'name'=>'user-search', 
	'url'=>array('user/userAutoCompleteLookup'), 
	'max'=>10,
	'minChars'=>1, 
	'extraParams'=>array('crawler_id'=>$_GET['crawlerID']),
	'delay'=>500,
	'matchCase'=>false,
	'htmlOptions'=>array('size'=>'40', 'class'=>'qtipped', 'title'=>'The Username of the User to search.'), 
	'methodChain'=>".result(function(event,item){\$(\"#UserCrawler_user_id\").val(item[1]);})",
);

$crawlerOptions = array(
	'name'=>'crawler-search', 
	'url'=>array('crawler/crawlerAutoCompleteLookup'), 
	'max'=>10,
	'minChars'=>1, 
	'extraParams'=>array('crawler_id'=>$_GET['crawlerID']),
	'delay'=>500,
	'matchCase'=>false,
	'htmlOptions'=>array('size'=>'40', 'class'=>'qtipped', 'title'=>'The Name of the Crawler to search.'), 
	'methodChain'=>".result(function(event,item){\$(\"#UserCrawler_crawler_id\").val(item[1]);})",
);



?>


<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

	<div class="row">
		<?php echo $form->label($model,'user_id'); ?>
		<?php $this->widget('CAutoComplete', $userOptions2 ); ?>
		<?php echo $form->hiddenField($model, 'user_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'crawler_id'); ?>
		<?php $this->widget('CAutoComplete', $crawlerOptions ); ?>
		<?php echo $form->hiddenField($model, 'crawler_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'can_read'); ?>
		<?php echo $form->dropDownList($model,'can_read', Lookup::items('UserCrawlerPermValue')); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'admin'); ?>
		<?php echo $form->dropDownList($model,'admin', Lookup::items('UserCrawlerPermValue')); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Search'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->