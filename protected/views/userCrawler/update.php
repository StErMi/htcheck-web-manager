<?php
$this->breadcrumbs=array(
	'Crawler Admin'=>array('crawler/admin'),
	$model->crawler->title,
	'User Crawlers',
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'Manage Crawlers', 'url'=>array('crawler/admin')),
	array('label'=>'Create UserCrawler', 'url'=>array('create', 'crawlerID'=>$model->crawler_id)),
	array('label'=>'Manage User Crawler', 'url'=>array('admin', 'crawlerID'=>$model->crawler_id)),
);
?>


<?php echo $this->renderPartial('_form', array('model'=>$model, 'formLegend' => 'Update permission of User ' . $model->user->username . ' for Crawler ' . $model->crawler->title )); ?>