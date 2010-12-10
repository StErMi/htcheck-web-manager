<?php
$this->breadcrumbs=array(
	Yii::app()->session['_db'] => array('htCheck/index'),
	'Accessibility Checks Search'
);

$ops = array();
$ops[] = array('label'=> 'Back to Crawler Index', 'url'=>array('htCheck/index'));
$ops[] = array('label'=>'Url List', 'url'=>array('url/index'));
$ops[] = array('label'=>'Search URLs', 'url'=>array('url/search'));
$ops[] = array('label'=>'Search Links', 'url'=>array('link/search'));
$ops[] = array('label'=>'Search Accessibility Checks', 'url'=>array('accessibility/search'));

$u = User::getMe();
$permissions = $u->getCrawlersPermissions( Yii::app()->session['_crawler_id'] );
if ( $permissions['config'] ) $ops[] = array('label'=>'Update Config', 'url'=>array('crawler/update', 'id'=>Yii::app()->session['_crawler_id']));
if ( $permissions['cron'] ) $ops[] = array('label'=>'Manage Crontab', 'url'=>array('crawlerCrontab/admin', 'crawlerID' => Yii::app()->session['_crawler_id']));

$this->menu=$ops;

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('accessibility-grid', {
		data: $(this).serialize()
	});
	return false;
});
");

$search = new AccessibilitySearchForm;
?>

<fieldset class="ui-widget ui-widget-content ui-corner-all">
<legend class="ui-widget ui-widget-header ui-corner-all">Search Accessibility Checks</legend>

<p>
You may optionally enter a comparison operator (<b>&lt;</b>, <b>&lt;=</b>, <b>&gt;</b>, <b>&gt;=</b>, <b>&lt;&gt;</b>
or <b>=</b>) at the beginning of each of your search values to specify how the comparison should be done.
</p>


<?php echo CHtml::link('Advanced Search','#',array('class'=>'search-button')); ?>
<div class="search-form">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
	'search' => $search,
)); ?>
</div><!-- search-form -->

<?php 

function showAction( $model ) {
	return CHtml::link( CHtml::image(Yii::app()->request->baseUrl.'/img/view.png', 'View Accessibility Check'), array('accessibility/view', 'IDUrl' => $model->IDUrl, 'TagPosition' => $model->TagPosition, 'AttrPosition' => $model->AttrPosition, 'Code' => $model->Code));
}

$this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'accessibility-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		array(
			'name'=>'url.Url',
			'type'=>'raw',
			'value'=>'CHtml::link(CHtml::encode($data->url->Url), $data->url->url)',
		),
		array(
			'name'=>'Code',
			'type'=>'raw',
			'value'=>'$data->getErrorErr()',
			'filter'=>$search->getErrorcodeList(),
		),
		array(
			'header'=>'Actions',
			'type'=>'raw',
			'value'=>'showAction( $data )',
		),
	),
	
)); ?>

</fieldset>

<script type="text/javascript">
	$(function(){
		// Tabs
		$('.search-form').hide();
	});
</script>
