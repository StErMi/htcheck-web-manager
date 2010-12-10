<?php
$this->breadcrumbs=array(
	'Users',
	$model->username=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'Create User', 'url'=>array('create')),
	array('label'=>'View User', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage User', 'url'=>array('admin')),
);
?>

<?php echo $this->renderPartial('_form', array('model'=>$model, 'formLegend' => 'Update user '.$model->username, 'old_pw'=>$old_pw )); ?>


