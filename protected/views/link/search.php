<?php
$this->breadcrumbs=array(
	Yii::app()->session['_db'] => array('htCheck/index'),
	'Link Search',
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

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('link-grid', {
		data: $(this).serialize()
	});
	return false;
});
");

$search = new LinkSearchForm;
?>

<fieldset class="ui-widget ui-widget-content ui-corner-all">
<legend class="ui-widget ui-widget-header ui-corner-all">Search Links</legend>

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

/*function getCorrectURL( $IDUrl, $url, $schedule_url ) {
	
	if (  $url !== null )
		return CHtml::link($url->Url, $url->getUrl ( $IDUrl ));
	else return $schedule_url->Url;
}*/

function getCorrectURL( $data ) {
	
	 /*<strong><?php echo $strReferencingUrl; ?></strong>: <a href="showurl.php?dbname=<?php echo $dbname; ?>&IDUrl=<?php echo $row["IDUrlSrc"]; ?>"><?php echo GetURL($row["UrlSrc"]); ?></a><br>
     <strong><?php echo $strReferencedUrl; ?></strong>: <a href="showurl.php?dbname=<?php echo $dbname; ?>&IDUrl=<?php echo $row["IDUrlDest"]; ?>"><?php echo GetURL($row["UrlDest"]); ?></a><br>
     <strong><?php echo $strHTMLStatement; ?></strong>: <?php echo $htmlstat; ?></td>
     */
	$s = '';
	$s .= 'Referencing URL: ';
	if ( $data->incoming_url !== null ) $s .= CHtml::link($data->incoming_url->Url, $data->incoming_url->getUrl ( $data->IDUrlDest )) . '<br />';
	else $s .= ' nothing';
	$s .= 'Referenced URL: ';
	if ( $data->incoming_url !== null ) $s .= CHtml::link($data->outgoing_url->Url, $data->outgoing_url->getUrl ( $data->IDUrlSrc )) . '<br />';
	else $s .= ' nothing';
	//$s .= 'HTML statement: ' . $data->hs->statement;
	return $s;
}

function showActionSRC( $model ) {
	return (strcmp($model->LinkType, 'Redirection')) ? CHtml::link( CHtml::image(Yii::app()->request->baseUrl.'/img/view.png', 'Link Info'), array('link/view', 'IDUrl' => $model->IDUrlSrc, 'TagPosition' => $model->TagPosition, 'AttrPosition' => $model->AttrPosition)) : '';
}

function showActionDST( $model ) {
	return (strcmp($model->LinkType, 'Redirection')) ? CHtml::link( CHtml::image(Yii::app()->request->baseUrl.'/img/view.png', 'Link Info'), array('link/view', 'IDUrl' => $model->IDUrlSrc, 'TagPosition' => $model->TagPosition, 'AttrPosition' => $model->AttrPosition)) : '';
}


$this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'link-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		array(
			'name'=>'incoming_url.Url',
			'header'=>'Referencing URL \ Referenced URL',
			'type'=>'raw',
			'value'=>'getCorrectURL($data)',
			'filter' => true,
		),
		
		array(
			'name' => 'LinkType',
			'filter'=>$search->getLinktypeList(false),
		),
		array(
			'name' => 'LinkResult',
			'filter'=>$search->getLinkresultList(),
		),
		
		array(
			'header'=>'Actions',
			'type'=>'raw',
			'value'=>'showActionSRC( $data )',
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


