<?php
$this->breadcrumbs=array(
	'Configurations'=>array('index'),
	$model->title,
	'View',
);

$this->menu=array(
	array('label'=>'Create Configurations', 'url'=>array('create')),
	array('label'=>'Manage Configurations', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage Configurations', 'url'=>array('admin')),
);

Yii::app()->clientScript->registerScript(
   'myHideEffect',
   '$(".flash-success").animate({opacity: 1.0}, 6000).fadeOut("slow");',
   CClientScript::POS_READY
);

?>

<h1>View Configuration <?php echo  $model->title; ?></h1>

<?php if(Yii::app()->user->hasFlash('success')):?>
    <div class="flash-success">
        <?php echo Yii::app()->user->getFlash('success'); ?>
    </div>
<?php endif; ?>

<p><font color="red">Please note that the configuration is in read-only mode</font></p>

<?php echo $this->renderPartial('_form', array('model'=>$model, 'readOnly'=>'readonly')); ?>