<?php
$this->breadcrumbs=array(
	'Configurations'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'Manage Configurations', 'url'=>array('admin')),
);
?>

<h1>Create Configuration</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model, 'readOnly'=>'')); ?>