<?php
$this->breadcrumbs=array(
	Yii::app()->session['_db'] => array('htCheck/index'),
	'URL List',
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

$search = new UrlSearchForm;

?>

<h1>List of retrieved Urls</h1>

<p>
You may optionally enter a comparison operator (<b>&lt;</b>, <b>&lt;=</b>, <b>&gt;</b>, <b>&gt;=</b>, <b>&lt;&gt;</b>
or <b>=</b>) at the beginning of each of your search values to specify how the comparison should be done.
</p>

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'url-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		array(
			'name'=>'Url',
			'type'=>'raw',
			'value'=>'CHtml::link(CHtml::encode($data->Url), $data->url)'
		),
		array(
			'name'=>'StatusCode',
			'filter'=>$search->getUrlStatusCodeList(false),
		),
		array(
			'name'=>'ReasonPhrase',
			'filter'=>$search->getUrlReasonPhraseList(),
		),
		array(
			'name'=>'ConnStatus',
			'filter'=>$search->getUrlConnStatusList(),
		),
	),
)); ?>

