
<?php 

$userOptions = array(
	'name'=>'user', 
	'url'=>array('user/userAutoCompleteLookup'), 
	'max'=>10,
	'minChars'=>1, 
	'extraParams'=>array('crawler_id'=>$model->crawler_id),
	'delay'=>500,
	'matchCase'=>false,
	'htmlOptions'=>array('size'=>'40', 'class'=>'qtipped', 'title'=>'The Username of the User.'), 
	'methodChain'=>".result(function(event,item){\$(\"#UserCrawler_user_id\").val(item[1]);})",
);



?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'user-crawler-form',
	'enableAjaxValidation'=>false,
)); ?>

	<fieldset class="ui-widget ui-widget-content ui-corner-all"> 
	<legend class="ui-widget ui-widget-header ui-corner-all"><?php echo $formLegend; ?></legend> 

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<?php echo CHtml::hiddenField('crawlerID', $model->crawler_id); ?>

	<div class="row">
		<?php if ( $model->isNewRecord ): ?>
		<?php echo $form->labelEx($model,'user_id'); ?>
		<?php $this->widget('CAutoComplete', $userOptions ); ?>
		<?php echo $form->hiddenField($model, 'user_id'); ?>
		<?php echo $form->error($model,'user_id'); ?>
		<?php else: ?>
		<b>User: </b>
		<?php echo CHtml::encode($model->user->username); ?>
		<br />
		<?php endif; ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'can_read'); ?>
		<?php echo $form->dropDownList($model,'can_read', Lookup::items('UserCrawlerPermValue') ); ?>
		<?php echo $form->error($model,'can_read'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'admin'); ?>
		<?php echo $form->dropDownList($model,'admin', Lookup::items('UserCrawlerPermValue') ); ?>
		<?php echo $form->error($model,'admin'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>
	
	</fieldset>

<?php $this->endWidget(); ?>

</div><!-- form -->

<script type="text/javascript">
	$(function(){
		
		// qtips
		$(".qtipped").qtip({ 
			style: { 
			 	width: 450,
		      	padding: 5,						
				name: 'cream', 
				tip: true 
			},
			position: {
		      corner: {
		         target: 'rightMiddle',
		         tooltip: 'leftMiddle'
		      }
		   },
			show: 'focus',
			hide: 'unfocus'
						  
					 
		});


		
	});
</script>
