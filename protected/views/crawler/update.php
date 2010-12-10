<?php
$this->breadcrumbs=array(
	'Crawlers',
	$model->title=>array('view','id'=>$model->id, 'title'=>$model->title),
	'Update',
);

$this->menu=array(
	array('label'=>'Create Crawler', 'url'=>array('create')),
	array('label'=>'View Crawler', 'url'=>array('view', 'id'=>$model->id, 'title'=>$model->title)),
	array('label'=>'Manage Crawler', 'url'=>array('admin')),
);
?>

<h1>Update Crawler <?php echo $model->title; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>