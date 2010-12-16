
<?php

$this->breadcrumbs=array(
	Yii::app()->session['_db'],
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

Yii::app()->clientScript->registerScript(
   'myHideEffect',
   '$(".flash-success").animate({opacity: 1.0}, 6000).fadeOut("slow");',
   CClientScript::POS_READY
);

?>

<h1>htCheck DB Detail <?php echo  Yii::app()->session['_db']; ?></h1>

<?php if(Yii::app()->user->hasFlash('success')):?>
    <div class="flash-success">
        <?php echo Yii::app()->user->getFlash('success'); ?>
    </div>
<?php endif; ?>

<div id="tabs">
	<ul>
		<li><a href="#tabs-1">General Informations</a></li>
		<li><a href="#tabs-2">Users & Permissions</a></li>
		<li><a href="#tabs-3">Scans & Crawler Config</a></li>
	</ul>
	<div id="tabs-1">
		<?php $this->renderPartial('_view', array(
			'data'=>$model,
			'db_info'=>$db_info,
		)); ?>
		
		<br />
		
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
		
	</div>
	<div id="tabs-2">
			<?php 
			
				function printPerm( $perm ) {
					if ( $perm ) return '<font color="green">YES</font>';
					else return '<font color="red">NO</font>';
				}
				echo '<ul>';
				foreach ( $users as $u ) {
					echo '<li>';
					$u->setCrawlersPermissions();
					$p = $u->getCrawlersPermissions( $crawler->id );
					echo $u->username . ' -  Permessi: Admin: ' . printPerm($p['admin']) . ' / Read: '  . printPerm($p['read']) . ' / EditConfig: '  . printPerm($p['config']) . ' / AddCronJob: '  . printPerm($p['cron']);
					echo '</li>'; 
				}
				echo '</ul>';
			
			?>
	</div>
	<div id="tabs-3">
		<h4>Programmed Scans</h4>
		<?php if ( $crawler->crons === null || count($crawler->crons) == 0 ): ?>
			<div class="flash-error">
			No Automatic scans added yet. Please <?php echo CHtml::link ('add', array('crawlerCrontab/admin', 'crawlerID'=>$crawler->id)); ?> at least one to update the crawler datas!
			</div>
		<?php else: ?>
			<ul>
			<?php foreach ( $crawler->crons as $c ): ?>
			<li><?php echo $c->toString(); ?></li>
			<?php endforeach;?>
			
			</ul>
		<?php endif; ?>
		<h4>Crawler Config</h4>
		<?php echo $crawler->toString( false ); ?>
	</div>
</div>



<script type="text/javascript">
	$(function(){
		// Tabs
		$('#tabs').tabs();
	});
</script>



