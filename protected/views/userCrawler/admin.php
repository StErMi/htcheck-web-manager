<?php
$this->breadcrumbs=array(
	'User Crawlers'=>array('index'),
	'Manage',
);

$this->menu=array(
	array('label'=>'Manage Crawlers', 'url'=>array('crawler/admin')),
	array('label'=>'Create UserCrawler', 'url'=>array('create', 'crawlerID'=>$_GET['crawlerID'])),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('user-crawler-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Manage User of Crawlers</h1>

<p>
You may optionally enter a comparison operator (<b>&lt;</b>, <b>&lt;=</b>, <b>&gt;</b>, <b>&gt;=</b>, <b>&lt;&gt;</b>
or <b>=</b>) at the beginning of each of your search values to specify how the comparison should be done.
</p>

<?php echo CHtml::link('Advanced Search','#',array('class'=>'search-button')); ?>
<div class="search-form" style="display:none">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->

<div class="flash-success" id="hidden_update_result" style="display:none;">The Relation to the Crawler has been <b>deleted</b> without problems!</div>

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'user-crawler-grid',
	'afterAjaxUpdate'=>'
				function(id, data) { 
					var divResult = $("#hidden_update_result");
			 		divResult.show();
			 		divResult.animate({opacity: 1.0}, 4000).fadeOut("slow");
				}
			',
	'dataProvider'=>$model->search( $_GET['crawlerID'] ),
	'filter'=>$model,
	'columns'=>array(
		'user.username',
		/*'crawler.title',
		array(
			'name'=>'crawler.title',deleteddeleted
			'header'=>'Crawler DB',
			'value'=>'$data->crawler->db_name_prepend.$data->crawler->db_name',
			'filter'=>false,
		),*/
		array(
			'name'=>'can_read',
			'value'=>'Lookup::item("UserCrawlerPermValue",$data->can_read)',
			'filter'=>Lookup::items('UserCrawlerPermValue'),
		),
		array(
			'name'=>'admin',
			'value'=>'Lookup::item("UserCrawlerPermValue",$data->admin)',
			'filter'=>Lookup::items('UserCrawlerPermValue'),
		),
		array(
			'header'=>'Actions',
			'class'=>'CButtonColumn',
			'template'=>'{update} {delete}',
		),
	),
)); ?>

