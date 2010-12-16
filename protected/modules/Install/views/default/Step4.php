<?php $this->pageTitle = Yii::app()->name.' - Admin User information';?>

<?php echo CHtml::beginForm(''); ?>
<fieldset class="ui-widget ui-widget-content ui-corner-all">
<legend class="ui-widget ui-widget-header ui-corner-all">Admin User information</legend>

<p class="emphasize">Please be careful. This is the first configuration of the Admin of htCheck Web Manager.</p>
<div class="form">
    <div class="content">
    
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
    
    </div>
</div>
</fieldset>
<?php echo CHtml::endForm();?>