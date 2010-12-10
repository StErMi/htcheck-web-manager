<?php
$this->breadcrumbs=array(
	'Groups',
	$model->title=>array('view','id'=>$model->id, 'title'=>$model->title),
	'Update',
);

$this->menu=array(
	array('label'=>'Create Group', 'url'=>array('create')),
	array('label'=>'View Group', 'url'=>array('view', 'id'=>$model->id, 'title'=>$model->title)),
	array('label'=>'Manage User in Group', 'url'=>array('manageUser', 'id'=>$model->id, 'title'=>$model->title)),
	array('label'=>'Manage Group', 'url'=>array('admin')),
);
?>


<?php echo $this->renderPartial('_form', array('model'=>$model, 'cgArray'=>$cgArray, 'clTitle' => $clTitle, 'formLegend' => 'Update Group: '.$model->title)); ?>