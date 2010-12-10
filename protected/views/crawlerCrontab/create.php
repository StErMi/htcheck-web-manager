<?php
$this->breadcrumbs=array(
	$crawler->title => array('crawler/view', 'id' => $crawler->id),
	'Manage Crontabs'=>array('admin', 'crawlerID' => $crawler->id),
	'Create Cron',
);

$this->menu=array(
	array('label'=>'Back to '.$crawler->title, 'url'=>array('crawler/view', 'id' => $crawler->id)),
	array('label'=>'Manage Crontab', 'url'=>array('admin', 'crawlerID' => $crawler->id)),
);
?>



<?php echo $this->renderPartial('_form', array('model'=>$model, 'model2'=>$model2)); ?>