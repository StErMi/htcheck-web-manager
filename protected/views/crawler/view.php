<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/css/main-old.css"></script>

<?php

$this->breadcrumbs=array(
	Yii::app()->session['_db'],
);

$ops = array();
/*
if ( !Yii::app()->user->isGuest && User::checkRole(TopUser::ROLE_ADMIN)  ) {
	$ops[] = array('label'=>'Crea un utente', 'url'=>array('user/create'));
	$ops[] = array('label'=>'Gestisci gli utenti', 'url'=>array('user/admin'));
}

if ( !Yii::app()->user->isGuest && TopUser::checkTopRole(TopUser::ROLE_USER) && User::checkRole(User::ROLE_ADMIN)  ) {
	$ops[] = array('label'=>'Gestisci gli utenti', 'url'=>array('user/adminDB'));
}
*/
$ops[] = array('label'=> Yii::app()->session['_db'].' Info', 'url'=>array('htCheck/index'));
$ops[] = array('label'=>'Url List', 'url'=>array('url/index'));
$ops[] = array('label'=>'Update Config', 'url'=>array('htCheck/updateConfig'));
$ops[] = array('label'=>'Manage Cronjob', 'url'=>array('htCheck/manageCron'));

$this->menu=$ops;



?>

<h1>Crawler #<?php echo  $crawler->title; ?></h1>

<?php if ( $model === null ): ?>
<div class="flash-notice">
The crawler never started. The <?php echo  $crawler->db_name_prepend.$crawler->db_name; ?>'s tables are still empty so there's no datas to show. <br />
Please remember to define crawler's automatic update operation in order to fill the database!
</div>
<?php else: ?>
<div class="flash-success">
This crawler has already collected some datas. Please select the database in the box on the right column and watch the crawler results.
</div>
<?php endif; ?>

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
			
				foreach ( $users as $uc ) {
					$u = $uc->user;
					$u->setCrawlersPermissions();
					$p = $u->getCrawlersPermissions( $crawler->id );
					echo $u->username . ' -  Permessi: Admin: ' . printPerm($p['admin']) . ' / Read: '  . printPerm($p['read']) . ' / EditConfig: '  . printPerm($p['config']) . ' / AddCronJob: '  . printPerm($p['cron']); 
				}
			
			
			?>
	</div>
	<div id="tabs-2">
			<h4>Parametri di Configurazione</h4>
			<?php echo $crawler->toString( false ); ?>
	</div>
	<div id="tabs-3">
			<h4>Next added cronjob</h4>
			<?php if ( count($crawler->crons) > 0 ): ?>
			<ul>
			<?php foreach ( $crawler->crons as $c ): ?>
			<li></li>
			<?php endforeach;?>
			
			</ul>
			<?php else: ?>
			There are no crons added at the moment.
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

