<?php
$this->breadcrumbs=array(
	'Groups',
	'Create',
);

$this->menu=array(
	array('label'=>'Manage Group', 'url'=>array('admin')),
);
?>


<?php echo $this->renderPartial('_form', array('model'=>$model, 'cgArray'=>$cgArray, 'clTitle' => $clTitle, 'formLegend' => 'Create Group')); ?>