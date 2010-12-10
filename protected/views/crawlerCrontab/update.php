<?php
$this->breadcrumbs=array(
	$crawler->title => array('crawler/view', 'id' => $crawler->id),
	'Manage Crontabs'=>array('admin', 'crawlerID' => $crawler->id),
	'Update',
);

$this->menu=array(
	array('label'=>'Back to '.$crawler->title, 'url'=>array('crawler/view', 'id' => $crawler->id)),
	array('label'=>'Manage Crontab', 'url'=>array('admin', 'crawlerID' => $crawler->id)),
	array('label'=>'Create new Crontab', 'url'=>array('create', 'crawlerID' => $crawler->id)),
);
?>

<h1>Update CrawlerCrontab <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>