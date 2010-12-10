<?php
$this->breadcrumbs=array(
	'Cookies'=>array('index'),
	$model->Name,
);

$this->menu=array(
	array('label'=>'List Cookies', 'url'=>array('index')),
	array('label'=>'Create Cookies', 'url'=>array('create')),
	array('label'=>'Update Cookies', 'url'=>array('update', 'id'=>$model->IDCookie)),
	array('label'=>'Delete Cookies', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->IDCookie),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Cookies', 'url'=>array('admin')),
);
?>

<h1>View Cookies #<?php echo $model->IDCookie; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'IDCookie',
		'Name',
		'Value',
		'Path',
		'Domain',
		'MaxAge',
		'Version',
		'SrcUrl',
		'Expires',
		'Secure',
		'DomainValid',
	),
)); ?>
