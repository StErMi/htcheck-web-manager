<?php
$this->breadcrumbs=array(
	'Crawler Admin'=>array('crawler/admin'),
	$crawler->title,
	'User Crawlers',
	'Create',
);

$this->menu=array(
	array('label'=>'Manage Crawlers', 'url'=>array('crawler/admin')),
	array('label'=>'Manage User Crawler', 'url'=>array('admin', 'crawlerID'=>$model->crawler_id)),
);
?>


<?php echo $this->renderPartial('_form', array('model'=>$model, 'formLegend' => 'Add User to a Crawler')); ?>

