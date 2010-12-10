
<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'user-form',
	'enableAjaxValidation'=>false,
)); ?>

	<fieldset class="ui-widget ui-widget-content ui-corner-all">
	<legend class="ui-widget ui-widget-header ui-corner-all"><?php echo $formLegend; ?></legend>

	<p class="note"><?php echo Yii::t('app', 'form_obbligo_1'); ?> <span class="required">*</span> <?php echo Yii::t('app', 'form_obbligo_2'); ?></p>

	<?php echo $form->errorSummary($model); ?>
	
	<?php if ( !$model->isNewRecord ): ?>
	<?php echo CHtml::hiddenField('old_pw', $old_pw); ?>
	<?php endif; ?>
	
	
	<div class="row">
		<?php if( User::checkRole(User::ROLE_ADMIN) || $model->isNewRecord ): ?>
		<?php echo $form->labelEx($model,'username'); ?>
		<?php echo $form->textField($model,'username',array('size'=>60,'maxlength'=>128)); ?>
		<?php echo $form->error($model,'username'); ?>
		<?php else: ?>
		<b>Username: </b> <?php echo CHtml::encode($model->username); ?>
		<?php endif; ?>
	</div>
	
	<div class="row">
		<?php echo $form->labelEx($model,'password'); ?>
		<?php echo $form->passwordField($model,'password',array('size'=>60,'maxlength'=>128)); ?>
		<?php echo $form->error($model,'password'); ?>
		<?php if ( !$model->isNewRecord ): ?>
		<p class="hint">
			Leave empty to not change your password.
		</p>
		<?php endif; ?>
	</div>
	
	<div class="row">
		<?php echo $form->labelEx($model,'email'); ?>
		<?php echo $form->textField($model,'email',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'email'); ?>
	</div>
	
	<div class="row">
		<?php echo $form->labelEx($model,'language'); ?>
		<?php echo $form->dropDownList($model,'language', Lookup::items('UserLanguage') ); ?>
		<?php echo $form->error($model,'language'); ?>
	</div>
	
	<?php if( User::checkRole(User::ROLE_ADMIN)): ?>
	<div class="row">
		<?php echo $form->labelEx($model,'role'); ?>
		<?php echo $form->dropDownList($model,'role', Lookup::items('UserRole') ); ?>
		<?php echo $form->error($model,'role'); ?>
	</div>
	<?php endif; ?>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>
	
	</fieldset>

<?php $this->endWidget(); ?>

</div><!-- form -->
