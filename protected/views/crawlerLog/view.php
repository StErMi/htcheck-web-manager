<?php
$this->breadcrumbs=array(
	Yii::app()->session['_db'] => array('htCheck/index'),
	'Crawler Logs'=>array('index', 'crawlerID' => Yii::app()->session['_crawler_id'] ),
	'LOG ID #'.$model->id,
);

$ops = array();
$ops[] = array('label'=> 'Back to Crawler Index', 'url'=>array('htCheck/index'));
$ops[] = array('label'=> 'View LOGs', 'url'=>array('crawlerLog/index', 'crawlerID' => Yii::app()->session['_crawler_id']));
$ops[] = array('label'=>'Url List', 'url'=>array('url/index'));
$ops[] = array('label'=>'Search URLs', 'url'=>array('url/search'));
$ops[] = array('label'=>'Search Links', 'url'=>array('link/search'));
$ops[] = array('label'=>'Search Accessibility Checks', 'url'=>array('accessibility/search'));

$u = User::getMe();
$permissions = $u->getCrawlersPermissions( Yii::app()->session['_crawler_id'] );
if ( $permissions['config'] ) $ops[] = array('label'=>'Update Config', 'url'=>array('crawler/update', 'id'=>Yii::app()->session['_crawler_id']));
if ( $permissions['cron'] ) $ops[] = array('label'=>'Manage Crontab', 'url'=>array('crawlerCrontab/admin', 'crawlerID' => Yii::app()->session['_crawler_id']));

$this->menu=$ops;

?>

<fieldset class="ui-widget ui-widget-content ui-corner-all">
<legend class="ui-widget ui-widget-header ui-corner-all">LOG #1 of Crawler <?php echo $model->crawler->title; ?></legend>

	<font color="green">
	<b>LOG ID #<?php echo CHtml::encode($model->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($model->id), array('view', 'id'=>$model->id)); ?>
	<br /><br />
	</font>

	<b>Crawler:</b>
	<?php echo CHtml::encode($model->crawler->title); ?>
	<br />

	<b><?php echo CHtml::encode($model->getAttributeLabel('version')); ?>:</b>
	<?php echo CHtml::encode($model->version); ?>
	<br />

	<b><?php echo CHtml::encode($model->getAttributeLabel('start_time')); ?>:</b>
	<?php echo CHtml::encode($model->start_time); ?>
	<br />

	<b><?php echo CHtml::encode($model->getAttributeLabel('end_time')); ?>:</b>
	<?php echo CHtml::encode($model->end_time); ?>
	<br />

	<b><?php echo CHtml::encode($model->getAttributeLabel('scheduled_urls')); ?>:</b>
	<?php echo CHtml::encode($model->scheduled_urls); ?>
	<br />

	<b><?php echo CHtml::encode($model->getAttributeLabel('tot_urls')); ?>:</b>
	<?php echo CHtml::encode($model->tot_urls); ?>
	<br />

	
	<b><?php echo CHtml::encode($model->getAttributeLabel('retrieved_urls')); ?>:</b>
	<?php echo CHtml::encode($model->retrieved_urls); ?>
	<br />

	<b><?php echo CHtml::encode($model->getAttributeLabel('tcp_connections')); ?>:</b>
	<?php echo CHtml::encode($model->tcp_connections); ?>
	<br />

	<b><?php echo CHtml::encode($model->getAttributeLabel('server_changes')); ?>:</b>
	<?php echo CHtml::encode($model->server_changes); ?>
	<br />

	<b><?php echo CHtml::encode($model->getAttributeLabel('http_requests')); ?>:</b>
	<?php echo CHtml::encode($model->http_requests); ?>
	<br />

	<b><?php echo CHtml::encode($model->getAttributeLabel('http_seconds')); ?>:</b>
	<?php echo CHtml::encode($model->http_seconds); ?>
	<br />

	<b><?php echo CHtml::encode($model->getAttributeLabel('http_bytes')); ?>:</b>
	<?php echo CHtml::encode($model->http_bytes); ?>
	<br />

	<b><?php echo CHtml::encode($model->getAttributeLabel('accessibility_checks')); ?>:</b>
	<?php echo CHtml::encode($model->accessibility_checks); ?>
	<br />

	<b><?php echo CHtml::encode($model->getAttributeLabel('htdig_notification')); ?>:</b>
	<?php echo CHtml::encode($model->htdig_notification); ?>
	<br />

	<b><?php echo CHtml::encode($model->getAttributeLabel('user')); ?>:</b>
	<?php echo CHtml::encode($model->user); ?>
	<br />

</fieldset>