<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/js/jquery-ui-1.8.2.custom.min.js"></script>
<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/js/jquery.qtip-1.0.0-rc3.min.js"></script>

<?php $this->pageTitle = Yii::app()->name.' - Databas setup';?>
<h1>Environment settings</h1>
<p class="emphasize">All fields are required and case sensitive.</p>
<div class="form">
    <h3></h3>
<div class="content">
<?php echo CHtml::beginForm('');?>
<fieldset>
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
    <?php echo CHtml::activeTextField($model, 'password', array('class'=>'qtipped', 'title'=>'The user\'s password used to access to HtCheck WebManager Database')); ?>
</div>
<div class="output">
    <?php echo CHtml::submitButton('Next', array('class'=>'button-2')); ?>
</div>
</fieldset>
<?php echo CHtml::endForm();?>
</div>
</div>

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
