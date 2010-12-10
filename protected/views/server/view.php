<?php
$this->breadcrumbs=array(
	'Servers'=>array('index'),
	$model->IDServer,
);

$this->menu=array(
	array('label'=>'List Server', 'url'=>array('index')),
	array('label'=>'Create Server', 'url'=>array('create')),
	array('label'=>'Update Server', 'url'=>array('update', 'id'=>$model->IDServer)),
	array('label'=>'Delete Server', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->IDServer),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Server', 'url'=>array('admin')),
);
?>

<h1>View Server #<?php echo $model->IDServer; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'IDServer',
		'Server',
		'IPAddress',
		'Port',
		'HttpServer',
		'HttpVersion',
		'PersistentConnection',
		'Requests',
	),
)); ?>
