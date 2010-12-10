

<?php
$this->breadcrumbs=array(
	'Groups',
	$model->title,
);

if ( User::checkRole(User::ROLE_ADMIN) ) {
	$this->menu=array(
		array('label'=>'Create Group', 'url'=>array('create')),
		array('label'=>'Update Group', 'url'=>array('update', 'id'=>$model->id, 'title'=>$model->title)),
		array('label'=>'Manage User in Group', 'url'=>array('manageUser', 'id'=>$model->id, 'title'=>$model->title)),
		array('label'=>'Delete Group', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
		array('label'=>'Manage Group', 'url'=>array('admin')),
	);
}

?>

<h1>View Group: <?php echo $model->title; ?></h1>



<fieldset class="ui-widget ui-widget-content ui-corner-all"> 
<legend class="ui-widget ui-widget-header ui-corner-all">User List</legend>
	<font color="green">User List:</font>  
	<?php 
		$uc = count($model->users);
		if ( $uc > 0 ) {
			for ( $i = 0; $i < $uc; $i++ ) {
				echo CHtml::link(CHtml::encode($model->users[$i]->username), $model->users[$i]->url);
				if ( $i != $uc -1 ) echo ', ';
			}
			echo '<br /><br /> ' . CHtml::link( CHtml::image( Yii::app()->request->baseUrl .'/img/user_add.png' ) . ' Add more users.', array('group/manageUser', 'id' => $model->id));
		} else echo 'Empty list, ' . CHtml::link( CHtml::image( Yii::app()->request->baseUrl .'/img/user_add.png' ) . ' Add more users.', array('group/manageUser', 'id' => $model->id));
	?>
</fieldset>
<?php foreach ( $model->crawler_groups as $cg ): ?>

<fieldset class="ui-widget ui-widget-content ui-corner-all"> 
<legend class="ui-widget ui-widget-header ui-corner-all">Crawler <?php echo $cg->crawler->title; ?></legend>

	User Permissions: 
	
	<b><?php echo CHtml::encode($cg->getAttributeLabel('read')); ?>:</b>
	<?php echo CHtml::activeCheckBox($cg, 'read', array('disabled'=>true)); ?>
	

	<b><?php echo CHtml::encode($cg->getAttributeLabel('config')); ?>:</b>
	<?php echo CHtml::activeCheckBox($cg, 'config', array('disabled'=>true)); ?>
	

	<b><?php echo CHtml::encode($cg->getAttributeLabel('cron')); ?>:</b>
	<?php echo CHtml::activeCheckBox($cg, 'cron', array('disabled'=>true)); ?>
	

	<b><?php echo CHtml::encode($cg->getAttributeLabel('admin')); ?>:</b>
	<?php echo CHtml::activeCheckBox($cg, 'admin', array('disabled'=>true)); ?>
	
	
</fieldset> 	
<?php endforeach; ?>	




