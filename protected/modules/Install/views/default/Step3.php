<?php $this->pageTitle = Yii::app()->name.' - Database setup';?>

<?php echo CHtml::beginForm('');?>

<fieldset class="ui-widget ui-widget-content ui-corner-all">
<legend class="ui-widget ui-widget-header ui-corner-all">Database Setup</legend>

<p class="emphasize">We have all information we need. Before continue, back up your database if you need as existing data might be lost.</p>
<div class="form">
    <div class="content">
    <?php if (Yii::app()->session->contains('env')===true) :?>
    	<p>Installer cannot create environment.php file.
    	<p><?php echo CHtml::link('Click here', array('default/step3'));?> to try again.</p>
    <?php endif;?>
    
    <?php if ($canConnect): ?>
        <p>Clicking on Next Button htCheck Installation Script will create all database tables and will set up default values.</p>
        
        <div class="output">
		    <a href="<?php echo $this->createUrl('default/step2General'); ?>">Back</a> or 
            <?php  echo CHtml::submitButton('Next', array('name'=>'install', 'class'=>'button-2')); ?>
        </div>
    <?php endif; ?>   
    </div>
</div>

</fieldset>

<?php echo CHtml::endForm();?>

