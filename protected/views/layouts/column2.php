<?php $this->beginContent('//layouts/main'); ?>
<div class="container">
	<div class="span-19">
		<div id="content">
			<?php echo $content; ?>
		</div><!-- content -->
	</div>
	<div class="span-5 last">
		<div id="sidebar">
		
		<?php 
		
			$u = User::getMe();
			$crawlerList = array();
			if ( $u !== null ) {
				$crawlerList = $u->getCrawlersList();
				if ( count($crawlerList) > 0 )
					$this->widget('DbBox', array( 'crawler_list' => $crawlerList ) ); 
			}
		?>
		
		<?php if(!Yii::app()->user->isGuest && User::checkRole(User::ROLE_ADMIN) ) $this->widget('AdminMenu', array( 'full' => true ) ); ?>
		
		<?php 
			// If the user is not an Admin the system will check if he can still administer some crawler 
			
			$finded = false;
			if ( $u !== null ) {
				$permissions = $u->getPermissions();
				foreach ( $permissions as $k=>$p) {
					if ( $p['admin'] == true ) {
						$finded = true;
						break;
					}
				}
			}
			if(!Yii::app()->user->isGuest && !User::checkRole(User::ROLE_ADMIN) && $finded ) $this->widget('AdminMenu', array( 'full' => false )); 
			
		?>
		
		<?php
			$this->beginWidget('zii.widgets.CPortlet', array(
				'title'=>'Operations',
			));
			$this->widget('zii.widgets.CMenu', array(
				'items'=>$this->menu,
				'htmlOptions'=>array('class'=>'operations'),
			));
			$this->endWidget();
			
			$this->widget('ActiveCrawlerBox' );
		?>
		
		
		
		</div><!-- sidebar -->
	</div>
</div>
<?php $this->endContent(); ?>

