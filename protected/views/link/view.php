<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/js/jquery-ui-1.8.2.custom.min.js"></script>
<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/css/main-old.css"></script>
<?php
$this->breadcrumbs=array(
	Yii::app()->session['_db'] => array('htCheck/index'),
	'Link Search' => array('link/search'),
	'URL'=>array('url/view', 'id'=>$_GET['IDUrl']),
	$model->outgoing_url->Url,
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



$dest_link = $model->incoming_url->Url;
$show_dest_link = $model->incoming_url->Url;
if (strlen($model->Anchor))
   {
      $dest_link .= "#" . $model->Anchor;
      $show_dest_link .= "#" . $model->Anchor;
   }


$ops[] = array('label'=>'Open referencing URL', 'url'=>$model->outgoing_url->Url);
$ops[] = array('label'=>'Open referenced URL', 'url'=>$dest_link);

if ( !empty($model->outgoing_url->Contents) )
	$ops[] = array('label'=>'Show the HTML source of this URL', 'url'=>array('url/viewSource', 'id'=>$model->IDUrlSrc, 'RowNumber'=>$hs->Row, '#'=>$hs->Row) );
	
$this->menu=$ops;



?>

<h1>View Link of url: <?php echo $model->outgoing_url->Url; ?></h1>

<div id="tabs">
	<ul>
		<li><a href="#tabs-1">Info available:</a></li>
		<li><a href="#tabs-2">Retrieving process</a></li>
		<li><a href="#tabs-3">Link has been issued by</a></li>
	</ul>
	<div id="tabs-1">
		<strong><font color="green">Open referencing URL in a new page: </font></strong> <?php echo CHtml::link($model->outgoing_url->Url, $model->outgoing_url->Url, array('target'=>'_BLANK')); ?><br />
		<strong><font color="green">Open referenced URL in a new page: </font></strong> <?php echo CHtml::link($show_dest_link, $dest_link, array('target'=>'_BLANK')); ?><br />
		<br />
		<strong>Referencing URL:</strong> <?php echo CHtml::link( $model->outgoing_url->Url, $model->outgoing_url->url ); ?><br />
		<strong>Referenced URL:</strong> <?php echo CHtml::link( $show_dest_link, $model->incoming_url->url ); ?> <br />
		<?php if ( !empty($model->Anchor) ): ?>
		<strong>Anchor:</strong> <?php echo CHtml::encode($model->Anchor); ?><br />
		<?php endif; ?>
		<strong>URL marked as:</strong> <?php echo $model->schedule->Status; ?><br />
		<strong>Link type:</strong> <?php echo $model->LinkType; ?><br />
		<strong>Result:</strong> <?php echo $model->LinkResult; ?><br />
		<strong>Link domain:</strong> <?php echo (empty($model->LinkDomain))?'Uknown':$model->LinkDomain; ?><br />
	</div>
	<div id="tabs-2">
		<?php if ( !empty($model->outgoing_url->StatusCode) ): ?>
		<strong>Status Code:</strong> <?php echo $model->outgoing_url->StatusCode; ?><br />
		<strong>Reason Phrase:</strong> <?php echo $model->outgoing_url->ReasonPhrase; ?><br />
		<strong>Content type: </strong> <?php echo $model->outgoing_url->ContentType; ?><br />
		<?php else: ?>
		<br /><h3>Url Not Retrived.</h3><br />
		<?php endif; ?>
	</div>
	
	<div id="tabs-3">
		<strong>HTML statement: </strong> &lt;<?php echo $hs->Statement; ?>&gt;<br />
		<strong>Row number of HTML statement: </strong> <?php echo $hs->Row; ?><br />
		<strong>HTML attribute: </strong> <?php echo $ha->Attribute; ?>="<?php echo $ha->Content; ?>"<br />
	</div>
	
</div>


<script type="text/javascript">
	$(function(){
		// Tabs
		$('#tabs').tabs();
	});
</script>
