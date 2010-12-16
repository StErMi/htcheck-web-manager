<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/js/jquery-ui-1.8.2.custom.min.js"></script>
<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/js/jquery.qtip-1.0.0-rc3.min.js"></script>

<?php $this->pageTitle = Yii::app()->name.' - Environment settings';?>

<?php echo CHtml::beginForm('');?>
<fieldset class="ui-widget ui-widget-content ui-corner-all">
<legend class="ui-widget ui-widget-header ui-corner-all">Environment settings</legend>
<p class="emphasize">All fields are required and case sensitive.</p>
<div class="form">
<div class="content">

<?php echo CHtml::errorSummary($model, '', '', array('class'=>'error')); ?>

<div class="input">
    <?php echo CHtml::activeLabel($model, 'db'); ?>
    <?php echo CHtml::activeDropDownList($model, 'db', array('mysql'=>'MySQL', 'pgsql'=>'PostgreSQL'), array('class'=>'qtipped', 'title'=>'Select the Database used for store HtCheck WebManager Tables')); ?>
</div>
<div class="input">
    <?php echo CHtml::activeLabel($model, 'host'); ?>
    <?php echo CHtml::activeTextField($model, 'host', array('class'=>'qtipped', 'title'=>'MySQL/PostgreSQL database server (usually localhost)')); ?>
</div>
<div class="input">
    <?php echo CHtml::activeLabel($model, 'dbName'); ?>
    <?php echo CHtml::activeTextField($model, 'dbName', array('class'=>'qtipped', 'title'=>'Default and recomended: htcheck_webmanager')); ?>
</div>
<div class="input">
    <?php echo CHtml::activeLabel($model, 'port'); ?>
    <?php echo CHtml::activeTextField($model, 'port', array('class'=>'qtipped', 'title'=>'Port to connect to your: MySQL server (usually 3306) / PostgreSQL server (usually 5432)')); ?>
    <div class="note"></div>
</div>
<div class="input">
    <?php echo CHtml::activeLabel($model, 'username'); ?>
    <?php echo CHtml::activeTextField($model, 'username', array('class'=>'qtipped', 'title'=>'The username used to access to HtCheck WebManager Database')); ?>
</div>
<div class="input">
    <?php echo CHtml::activeLabel($model, 'password'); ?>
    <?php echo CHtml::activePasswordField($model, 'password', array('class'=>'qtipped', 'title'=>'The user\'s password used to access to HtCheck WebManager Database')); ?>
</div>
<div class="input">
    <?php echo CHtml::label( 'HtCheck path', 'web_manager_path'); ?>
    <?php echo CHtml::textField('web_manager_path', '/usr/bin', array('class'=>'qtipped', 'title'=>'Path to the executable htcheck file. Default: /usr/bin ( remember to remvoe the final /')); ?>
</div>
<div class="output">
    <?php echo CHtml::submitButton('Next', array('class'=>'button-2')); ?>
</div>


</div>
</div>
</fieldset>
<?php echo CHtml::endForm();?>

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
