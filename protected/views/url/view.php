<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/js/jquery-ui-1.8.2.custom.min.js"></script>
<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/css/main-old.css"></script>
<?php
$this->breadcrumbs=array(
	Yii::app()->session['_db'] => array('htCheck/index'),
	'URL List' => array('url/index'),
	$model->Url,
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

/* Preparing the Location informations */
/* The URL has been redirected, so no outcoming info and size info
 * We should retrieve the Index of the redirected URL
 */

$loc = array();

if ( $model->Location ) {
	
	$connection = $model->dbConnection;
	$sql = "SELECT IDUrl FROM Schedule WHERE Url='" . $model->Location . "'";
	$command = $connection->createCommand($sql);
	$loc = $command->queryAll();
	
	/* BUG? ad esempio con www.devise.it Location non e' vuoto ma non c'e' un IDUrl associato */
	if ( count($loc) > 0 ) 
		$IDLocation = $loc[0]['IDUrl'];
	else 
		$IDLocation = -1;
}

/* Preparing datas */
$model->Title = (empty($model->Title)) ? 'Not defined' : $model->Title;
$model->Charset = (empty($model->Charset)) ? 'Not defined' : $model->Charset;
$model->DocType = (empty($model->DocType)) ? 'Not defined' : $model->DocType;
$model->ContentLanguage = (empty($model->ContentLanguage)) ? '---' : $model->ContentLanguage;
$model->LastModified = (!strncmp($model->LastModified, '0000', 4)) ? 'No last modified value available' : $model->LastModified . ' GMT';
$model->Description = (empty($model->Description)) ? 'Not defined' : $model->Description;
$model->Keywords = (empty($model->Keywords)) ? 'Not defined' : $model->Keywords;
$model->LastAccess = (!strncmp($model->LastAccess, '0000', 4)) ? 'No last modified value available' : $model->LastAccess . ' GMT';
$model->schedule->Url = (empty($model->schedule->Url) ) ? '---' : $model->schedule->Url;
$model->TransferEncoding = (empty($model->TransferEncoding)) ? '---' : $model->TransferEncoding;

/* Preparing Indexes of Web Structure Mining */
$strSQL = "SELECT COUNT(*) " .
         " FROM Link" .
         " WHERE Link.IDUrlSrc=$model->IDUrl" .
         " AND Link.LinkType='Normal'"; 
$NumWSM_OL = Url::model()->countBySql( $strSQL );


$strSQL = "SELECT COUNT(*) " .
         " FROM Link" .
         " WHERE Link.IDUrlDest=$model->IDUrl" .
         " AND Link.LinkType='Normal'"; 

$NumWSM_IL = Url::model()->countBySql( $strSQL );

$strSQL = "SELECT DISTINCT IDUrlDest " .
         " FROM Link" .
         " WHERE Link.IDUrlSrc=$model->IDUrl" .
         " AND Link.LinkType='Normal'"; 

$NumWSM_OD = Url::model()->countBySql( $strSQL );

$strSQL = "SELECT DISTINCT IDUrlSrc " .
         " FROM Link" .
         " WHERE Link.IDUrlDest=$model->IDUrl" .
         " AND Link.LinkType='Normal'"; 

$NumWSM_ID = Url::model()->countBySql( $strSQL );

// Calculates the total number of documents from links and links themselves
// Obviously documents from links are always <= than links
$NumWSM_L = $NumWSM_OL + $NumWSM_IL;
$NumWSM_D = $NumWSM_OD + $NumWSM_ID;
$ProWSM_OL = ($NumWSM_L > 0)?($NumWSM_OL / $NumWSM_L):0;
$ProWSM_IL = ($NumWSM_L > 0)?($NumWSM_IL / $NumWSM_L):0;
$ProWSM_OD = ($NumWSM_D > 0)?($NumWSM_OD / $NumWSM_D):0;
$ProWSM_ID = ($NumWSM_D > 0)?($NumWSM_ID / $NumWSM_D):0;

?>

<h1>View Url #<?php echo $model->IDUrl; ?>: <?php echo $model->Url; ?></h1>

<div id="tabs">
	<ul>
		<li><a href="#tabs-1">Info available:</a></li>
		<li><a href="#tabs-2">Retrieving process</a></li>
		<?php if ( !$model->Location ): ?>
			<li><a href="#tabs-3">Size of the resource</a></li> 
			<li><a href="#tabs-4">Indexes of Web Structure Mining</a></li>
		<?php else: ?>
			<li><a href="#tabs-3">Indexes of Web Structure Mining</a></li>
		<?php endif; ?>
	</ul>
	<div id="tabs-1">
		<strong><font color="green">Open the URL in a new page: </font></strong> <?php echo CHtml::link($model->Url, $model->Url, array('target'=>'_BLANK')); ?><br />
		<br />
		<strong>Page Title:</strong> <?php echo $model->Title; ?><br />
		<strong>Server:</strong> <?php echo $model->server->Server; ?> <br />
		<strong>Content type:</strong> <?php echo $model->ContentType; ?><br />
		<strong>Charset:</strong> <?php echo $model->Charset; ?><br />
		<strong>DocType:</strong> <?php echo $model->DocType; ?><br />
		<strong>Content language:</strong> <?php echo $model->ContentLanguage; ?><br />
		<strong>Last modified time:</strong> <?php echo $model->LastModified; ?><br />
		<strong>Page description:</strong> <?php echo $model->Description; ?><br />
		<strong>Page keywords:</strong> <?php echo $model->Keywords; ?><br />
	</div>
	<div id="tabs-2">
		<strong>Last access time:</strong> <?php echo $model->LastAccess; ?><br />
		<strong>Status Code:</strong> <?php echo $model->StatusCode; ?><br />
		<strong>Reason Phrase:</strong> <?php echo $model->ReasonPhrase; ?><br />
		<strong>Referer URL:</strong> <?php echo $model->schedule->Url; ?><br />
		<strong>Hop count (distance in clicks from the starting page):</strong> <?php echo $model->schedule->HopCount; ?><br />
		<?php if ( $model->Location && count($loc) > 0 ): ?>
		<strong>Location:</strong> <?php echo CHtml::link( $model->Location, array( 'url/view', 'id' => $IDLocation ) ); ?><br />
		<?php endif; ?>
		<strong>Connection Status:</strong> <?php echo $model->ConnStatus; ?><br />
		<strong>Transfer Encoding:</strong> <?php echo $model->TransferEncoding; ?><br />
	</div>
	<?php if ( !$model->Location ): ?>
	<div id="tabs-3">
		<strong>Size:</strong> <?php echo ($model->Size > 0 ) ? $model->Size . ' Bytes' : 'Unknow'; ?><br />
		<?php if ($model->Size > 0 ): ?>
		<strong>Size of resources loaded together (images, sounds, ...):</strong> <?php echo $model->SizeAdd . ' Bytes'; ?><br />
		<strong>Total weight of the page (caching supposed):</strong> <?php echo $model->SizeAdd+$model->Size . ' Bytes'; ?><br />
		<?php endif; ?>
	</div>
	<?php endif; ?>
	
	<div id="tabs-<?php echo ( !$model->Location ) ? 4 : 3; ?>">


<table>
<tr>
<td>

<table class="wsm_graph">
	<tr>
		<td class="wsm_column">Characteristics of links: &nbsp;</td>
		<td>
			<?php if ($NumWSM_L > 0) : ?>
			<?php if ($NumWSM_OL > 0) : ?>
			<img src="<?php echo Yii::app()->request->baseUrl; ?>/img/out.png" align="middle" hspace="2" alt="<?php
			   echo 'OL/L' . ': ' . number_format($ProWSM_OL, 2); ?>" height="5"
			   width="<?php echo number_format(100*$ProWSM_OL, 0); ?>" border="1" bordercolor="black"><?php
			   endif;
			   if ($NumWSM_IL > 0) : ?><img src="<?php echo Yii::app()->request->baseUrl; ?>/img/in.png" align="middle" hspace="2" alt="<?php
			   echo 'IL/L' . ': ' . number_format($ProWSM_IL, 2); ?>" height="5"
			   width="<?php echo number_format(100*$ProWSM_IL, 0); ?>" border="1" bordercolor="black"><?php
			   endif; ?>
			<?php else: ?>-
			<?php endif; ?>
		</td>
	</tr>

	<tr>
		<td class="wsm_column">Characteristics of linked documents: &nbsp;</td>
		<td>
			<?php if ($NumWSM_D > 0) : ?>
			<?php if ($NumWSM_OD > 0) : ?>
			<img src="<?php echo Yii::app()->request->baseUrl; ?>/img/out.png" align="middle" hspace="2" alt="<?php
			   echo 'OD/D' . ': ' . number_format($ProWSM_OD, 2); ?>" height="5"
			   width="<?php echo number_format(100*$ProWSM_OD, 0); ?>" border="1" bordercolor="black"><?php
			   endif;
			   if ($NumWSM_ID > 0) : ?><img
			   src="<?php echo Yii::app()->request->baseUrl; ?>/img/in.png" align="middle" hspace="2" alt="<?php
			   echo 'ID/D' . ': ' . number_format($ProWSM_ID, 2); ?>" height="5"
			   width="<?php echo number_format(100*$ProWSM_ID, 0); ?>" border="1" bordercolor="black"><?php
			   endif; ?>
			<?php else: ?>-
			<?php endif; ?>
		</td>
	</tr>

	<tr>
		<td colspan="2" class="wsm_notes">
			<table>
				<tr>
					<td>
						<img src="<?php echo Yii::app()->request->baseUrl; ?>/img/out.png" hspace="2" alt="Outgoing" height="5" width="5" border="1" bordercolor="black">
					</td>
					<td>Outgoing</td>
					<td> &nbsp; - &nbsp;</td>
					<td>
					<img src="<?php echo Yii::app()->request->baseUrl; ?>/img/in.png" hspace="2" alt="Incoming" height="5" width="5" border="1" bordercolor="black">
					</td>
					<td>Incoming</td>
				</tr>
			</table>
		</td>
	</tr>
</table>
</td>

<td>
	<table class="wsm_data">
		<tr>
			<th colspan="2">Rapporti</th>
		</tr>
	
		<tr>
			<td class="wsm_column">OL/IL: &nbsp;</td>
			<td>
			<?php if ($NumWSM_IL > 0)
			      echo number_format(($NumWSM_OL / $NumWSM_IL), 2);
			   else echo '-'; 
			?>
			</td>
		</tr>
	
		<tr>
			<td class="wsm_column">OD/ID: &nbsp;</td>
			<td>
			<?php if ($NumWSM_ID > 0)
			      echo number_format(($NumWSM_OD / $NumWSM_ID), 2);
			   else echo '-'; 
			?>
			</td>
		</tr>
	
	</table>
</td>

<td>
	<strong>Notes:</strong> <br/><br/>
	<ul>
	<li><strong>L:</strong> links, both ingoing (from different documents) and outgoing for this URL</li>
	<li><strong>D:</strong> documents, related to this URL by both outgoing and incoming links</li>
	<li><strong>OL:</strong> outgoing links from this URL to others</li>
	<li><strong>IL:</strong> incoming links coming to this URL from different ones</li>
	<li><strong>OD:</strong> documents linked to this URL by outgoing links within it</li>
	<li><strong>ID:</strong> documents which have links to this URL</li>
	</ul>
</td>

</tr>
</table>	

	</div>
	
</div>
<br />
<h3>Info about outgoing links</h3>

<?php 



/* TODO se e' EMAIL o JS allora non ritorno alcuna URL ???? */
/* TODO altrimenti, se non esiste il record in URL devo prenderlo in SCHEDULE? */

/*function getCorrectURLName( $url, $schedule_url ) {
	return (( $url !== null) ? $url->Url : $schedule_url->Url);
}

function getCorrectURL( $url, $schedule_url ) {
	return (( $url !== null) ? $url->url : $schedule_url->url);
}*/

function getCorrectURL( $IDUrl, $url, $schedule_url ) {
	//CHtml::link(getCorrectURLName($data->incoming_url, $data->schedule), getCorrectURL($data->incoming_url, $data->schedule))
	if (  $url !== null )
		return CHtml::link($url->Url, $url->getUrl ( $IDUrl ));
	else return $schedule_url->Url;
}

function showActionSRC( $model ) {
	return (strcmp($model->LinkType, 'Redirection')) ? CHtml::link( CHtml::image(Yii::app()->request->baseUrl.'/img/view.png', 'Link Info'), array('link/view', 'IDUrl' => $model->IDUrlSrc, 'TagPosition' => $model->TagPosition, 'AttrPosition' => $model->AttrPosition)) : '';
}

function showActionDST( $model ) {
	return (strcmp($model->LinkType, 'Redirection')) ? CHtml::link( CHtml::image(Yii::app()->request->baseUrl.'/img/view.png', 'Link Info'), array('link/view', 'IDUrl' => $model->IDUrlSrc, 'TagPosition' => $model->TagPosition, 'AttrPosition' => $model->AttrPosition)) : '';
}

/*function printIF1 ( $statusCode, $toPrint ) {
	if ( $statusCode ) return $toPrint;
	else return 'URL not retrieved';
}*/

function printIFStatusCode( $url ) {
	if ( !empty($url) && !empty($url->StatusCode) )
		return $url->StatusCode;
	else return 'URL not retrieved';
}

function printIFReasonPhrase( $url ) {
	if ( !empty($url) && !empty($url->StatusCode) )
		return $url->ReasonPhrase;
	else return 'URL not retrieved';
}

function printIFContentType( $url ) {
	if ( !empty($url) && !empty($url->StatusCode) )
		return $url->ContentType;
	else return 'URL not retrieved';
}

$search = new LinkSearchForm;

$this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'url-grid-outgoing-links-results',
	'dataProvider'=>$outgoing_link_results->outgoing_results( $model->IDUrl ),
	'filter'=>$outgoing_link_results,
	'columns'=>array(
		array(
			'name'=>'incoming_url.Url',
			'type'=>'raw',
			//'value'=>'CHtml::link(getCorrectURLName($data->incoming_url, $data->schedule), getCorrectURL($data->incoming_url, $data->schedule))',
			'value'=>'getCorrectURL($data->IDUrlDest, $data->incoming_url, $data->schedule)',
			'filter' => true,
		),
		array(
			'name' => 'schedule.Status',
			'header'=> 'URL marked as'
		),
		array(
			'name' => 'LinkType',
			'filter'=>$search->getLinktypeList(false, $model->IDUrl, -1),
		),
		array(
			'name'=>'incoming_url.StatusCode',
			'header' => 'StatusCode',
			'value'=>'printIFStatusCode ($data->incoming_url)',
		),
		array(
			'name'=>'incoming_url.ReasonPhrase',
			'header' => 'ReasonPhrase',
			'value'=>'printIFReasonPhrase ($data->incoming_url)',
		),
		array(
			'name'=>'incoming_url.ContentType',
			'header' => 'ContentType',
			'value'=>'printIFContentType ($data->incoming_url)',
		),
		array(
			'header'=>'Actions',
			'type'=>'raw',
			'value'=>'showActionSRC( $data )',
		),
		
		/*array(
			'class'=>'CButtonColumn',
			'template'=>'{view_info}',
			'header' => 'Actions',
			'buttons' => array(
				'view_info' => array(
				    'label'=>'Link Info', 
				    'url'=> 'Yii::app()->createUrl( "/link/view", array( "id"=>$data->IDUrlSrc ))',
				    'imageUrl'=>Yii::app()->request->baseUrl.'/img/view.png',  
				    'visible'=>'1',  
				),
			),
		)*/
		
	),
)); ?>

<h3>Info about incoming links</h3>
<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'url-grid-incoming-links-results',
	'dataProvider'=>$incoming_link_results->incoming_results( $model->IDUrl ),
	'filter'=>$incoming_link_results,
	'columns'=>array(
		array(
			'name'=>'outgoing_url.Url',
			'type'=>'raw',
			//'value'=>'CHtml::link(getCorrectURLName($data->outgoing_url, $data->schedule), getCorrectURL($data->outgoing_url, $data->schedule))',
			/* TODO: controllare se devo passare anche qui IDUrlSrc */
			'value'=>'getCorrectURL($data->IDUrlSrc, $data->outgoing_url, $data->schedule)',
			'filter' => true,
		),
		array(
			'name' => 'LinkType',
			'filter'=>$search->getLinktypeList(false, -1, $model->IDUrl),
		),
		array(
			'name'=>'outgoing_url.ContentType',
			'header' => 'ContentType',
			'value'=>'printIFContentType ($data->outgoing_url)',
		),
		array(
			'header'=>'Actions',
			'type'=>'raw',
			'value'=>'showActionDST( $data )',
		),
		
		
		/*array(
			'class'=>'CButtonColumn',
			'template'=>'{view_info}',
			'header' => 'Actions',
			'buttons' => array(
				'view_info' => array(
				    'label'=>'Link Info', 
				    'url'=> 'Yii::app()->createUrl( "/link/view", array( "id"=>$data->IDUrlSrc ))',
				    'imageUrl'=>Yii::app()->request->baseUrl.'/img/view.png',  
				    'visible'=>'1',  
				),
			),
		)*/
		
	),
)); ?>


<script type="text/javascript">
	$(function(){
		// Tabs
		$('#tabs').tabs();
	});
</script>

