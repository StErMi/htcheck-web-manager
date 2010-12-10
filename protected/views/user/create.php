<?php
$this->breadcrumbs=array(
	'Users',
	'Create',
);

$this->menu=array(
	array('label'=>'Manage User', 'url'=>array('admin')),
);
?>


<?php echo $this->renderPartial('_form', array('model'=>$model, 'formLegend' => 'Create a new User' )); ?>
