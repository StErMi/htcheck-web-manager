<?php 

if ( !Yii::app()->user->isGuest ) {
	$u = User::getMe();
	$u->setCrawlersPermissions(); //Ho bisogno di aggiornare i permessi per poter controllare lo status del crawler
	$permissions = $u->getPermissions();
} else $permissions = array();
$atLeastOne = false;
?>
<ul>
	<?php if ( count($permissions) > 0 ): ?>
		<?php foreach ( $permissions as $crawlerID => $p ): ?>
			<?php if ( $p['model']->status == true ): ?>
				<li><b><font color="green"><?php echo $p['title']; ?></font></b></li>
				
			<?php $atLeastOne = true; endif; ?>
		<?php endforeach; ?>
		<?php if ( !$atLeastOne ): ?>
			No crawlers active at the moment.
		<?php endif; ?>
	<?php else: ?>
		No crawlers active at the moment.
	<?php endif; ?>
</ul>
