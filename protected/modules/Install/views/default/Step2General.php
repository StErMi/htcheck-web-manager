
<?php $this->pageTitle = Yii::app()->name.' - Databas setup';?>

<?php echo CHtml::beginForm('');?>
<fieldset class="ui-widget ui-widget-content ui-corner-all">
<legend class="ui-widget ui-widget-header ui-corner-all">Environment settings</legend>

<p class="emphasize">All fields are required and case sensitive.</p>
<div class="form">
<div class="content">


<?php echo CHtml::errorSummary($model, '', '', array('class'=>'error')); ?>

<div class="input">
    <?php echo CHtml::activeLabel($model, 'host'); ?>
    <?php echo CHtml::activeTextField($model, 'host',  array('class'=>'qtipped', 'title'=>'MySQL database server (usually localhost)')); ?>
</div>
<div class="input">
    <?php echo CHtml::activeLabel($model, 'port'); ?>
    <?php echo CHtml::activeTextField($model, 'port',  array('class'=>'qtipped', 'title'=>'Port to connect to your MySQL server (usually 3306)')); ?>
</div>

<div class="input">
    <?php echo CHtml::activeLabel($model, 'username'); ?>
    <?php echo CHtml::activeTextField($model, 'username', array('class'=>'qtipped', 'title'=>'The username used to access to HtCheck WebManager Database')); ?>
</div>
<div class="input">
    <?php echo CHtml::activeLabel($model, 'password'); ?>
    <?php echo CHtml::activePasswordField($model, 'password', array('class'=>'qtipped', 'title'=>'The user\'s password used to access to HtCheck WebManager Database')); ?>
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
