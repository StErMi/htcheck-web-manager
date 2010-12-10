
<?php

$this->breadcrumbs=array(
	Yii::app()->session['_db'],
);

$this->menu=array(
	array('label'=>'Url List', 'url'=>array('url/index')),
);
?>

<h1>htCheck DB Detail #<?php echo  Yii::app()->session['_db']; ?></h1>


<?php $this->renderPartial('_view', array(
	'data'=>$model,
	'db_info'=>$db_info,
)); ?>

<h3>Summary of HTTP requests results</h3>

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'url-grid-HTTP-results',
	'dataProvider'=>$http_results->HTTP_results(),
	'filter'=>$http_results,
	'columns'=>array(
		'StatusCode', /* TODO: aggiungere SELECT per scegliere */
		'ReasonPhrase', /* TODO: aggiungere SELECT per scegliere */
		array(
			'header'=>'Count',
			'value'=>'$data->HTTP_results_count()',
		),
	),
)); ?>

<h3>Summary of HTTP Servers that have been seen (ordered by requests)</h3>

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'url-grid-Servers-seen',
	'dataProvider'=>$server_seen->Server_seen(),
	'filter'=>$server_seen,
	'columns'=>array(
		'Server',
		'Port',
		'HttpServer',
		'HttpVersion', /* TODO: aggiungere SELECT per scegliere version */
		array(
			'name'=>'Requests',
			'filter'=>false,
		),
	),
)); ?>

<h3>Summary of Connection results</h3>

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'url-grid-Connection-results',
	'dataProvider'=>$connection_results->Connection_results(),
	'filter'=>$connection_results,
	'columns'=>array(
		'ConnStatus', /* TODO: aggiungere SELECT per scegliere */
		array(
			'header'=>'Count',
			'value'=>'$data->Connection_results_count()',
		),
	),
)); ?>

<h3>Summary of Content-Type encountered</h3>

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'url-grid-Content-Type-results',
	'dataProvider'=>$contenttype_results->ContentType_results(),
	'filter'=>$contenttype_results,
	'columns'=>array(
		'ContentType', /* TODO: aggiungere SELECT per scegliere */
		array(
			'header'=>'Count',
			'value'=>'$data->ContentType_results_count()',
		),
	),
)); ?>

<h3>Summary of the cookies retrieved</h3>

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'url-grid-Content-Type-results',
	'dataProvider'=>$cookies_results->Cookies_results(),
	'filter'=>$cookies_results,
	'columns'=>array(
		'Name', 
		'Value', 
		'Path', 
		'Domain', 
		'SrcUrl',
	),
)); ?>



