<?php $this->pageTitle = Yii::app()->name.' - Admin User information';?>

<h1>Admin User information</h1>
<p class="emphasize">Please be careful. This is the first configuration of the Admin of htCheck Web Manager.</p>
<div class="form">
    <h3></h3>
    <div class="content">
    <?php echo CHtml::beginForm(''); ?>
    <fieldset>
    <?php echo CHtml::errorSummary($model, null, null, array('class'=>'error')); ?>
    <div class="input">
        <?php echo CHtml::activeLabel($model, 'username'); ?>
        <?php echo CHtml::activeTextField($model, 'username', array('class' => 'text1')); ?>
    </div>
    <div class="input">
        <?php echo CHtml::activeLabel($model, 'password'); ?>
        <?php echo CHtml::activePasswordField($model, 'password', array('class' => 'text1')); ?>
        <div class="note">Double-check your password before continuing</div>
    </div>
    <div class="input">
        <?php echo CHtml::activeLabel($model, 'email'); ?>
        <?php echo CHtml::activeTextField($model, 'email', array('class' => 'text1')); ?>
        <div class="note">Insert your email address to receive scan's reports.</div>
    </div>
    <div class="output">
        <?php echo CHtml::submitButton('Next', array('class'=>'button-2')); ?>
    </div>
    </fieldset>
    <?php echo CHtml::endForm();?>
    </div>
</div>
