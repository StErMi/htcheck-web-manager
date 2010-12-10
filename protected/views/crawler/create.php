<?php
$this->breadcrumbs=array(
	'Crawlers'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List Crawler', 'url'=>array('index')),
	array('label'=>'Manage Crawler', 'url'=>array('admin')),
);
?>

<h1>Create Crawler</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>