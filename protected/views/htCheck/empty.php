
<?php

$this->breadcrumbs=array(
	Yii::app()->session['_db'],
);



$ops = array();
$ops[] = array('label'=> 'Back to Crawler Index', 'url'=>array('htCheck/index'));
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

<div class="flash-notice">
The crawler never started. The <?php echo  Yii::app()->session['_db']; ?>'s tables are still empty so there's no datas to show. <br />
Please remember to define crawler's automatic update operation in order to fill the database!
</div>

<div id="tabs">
	<ul>
		<li><a href="#tabs-1">Users & Permissions</a></li>
		<li><a href="#tabs-2">Crawler Config</a></li>
		<li><a href="#tabs-3">Automatic Update</a></li>
	</ul>
	<div id="tabs-1">
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
	<div id="tabs-2">
			<h4>Parametri di Configurazione</h4>
			<?php echo $crawler->toString( false ); ?>
	</div>
	<div id="tabs-3">
			<h4>Next added cronjob</h4>
			<?php if ( $crawler->crons === null || count($crawler->crons) == 0 ): ?>
				<div class="flash-error">
				No Automatic Cronjob added yet. Please add <?php echo CHtml::link ('add', array('crawlerCrontab/admin', 'crawlerID'=>$crawler->id)); ?> at least one to update the crawler datas!
				</div>
			<?php else: ?>
				<ul>
				<?php foreach ( $crawler->crons as $c ): ?>
				<li><?php echo $c->toString(); ?></li>
				<?php endforeach;?>
				
				</ul>
			<?php endif; ?>
	</div>
</div>

<br />




<script type="text/javascript">
	$(function(){
		// Tabs
		$('#tabs').tabs();
	});
</script>


