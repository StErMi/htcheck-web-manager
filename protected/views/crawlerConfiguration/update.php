<?php
$this->breadcrumbs=array(
	'Crawler Configurations',
	$model->title=>array('view','id'=>$model->id, 'title'=>$model->title),
	'Update',
);

$this->menu=array(
	array('label'=>'Create Configuration', 'url'=>array('create')),
	array('label'=>'View Configuration', 'url'=>array('view', 'id'=>$model->id, 'title'=>$model->title)),
	array('label'=>'Manage Configurations', 'url'=>array('admin')),
);
?>

<h1>Update Configuration: <?php echo $model->title; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model, 'readOnly'=>'')); ?>