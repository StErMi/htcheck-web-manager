<?php
$this->breadcrumbs=array(
	'Users',
	$model->username,
);

$this->menu=array(
	array('label'=>'Create User', 'url'=>array('create')),
	array('label'=>'Update User', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete User', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage User', 'url'=>array('admin')),
);

//Preparing user groups
$ugs = '';
foreach ( $model->user_groups as $ug ) {
	$ugs .= CHtml::link( CHtml::encode($ug->title), $ug->url ) .', ';
}
$ugs = substr($ugs, 0, -2);

function printPerm( $perm ) {
	if ( $perm ) return '<font color="green">YES</font>';
	else return '<font color="red">NO</font>';
}

//Preparing 
$ucs = '';
$model->setCrawlersPermissions();
foreach ( $model->crawler_permissions as $cID => $cp  ) {
	$ucs .= CHtml::link( CHtml::encode($cp['model']->title), $cp['model']->url ) . ' Permissions: <br />';
	$ucs .= '<ul>';
	$ucs .= '<li>Admin: ' . printPerm($cp['admin']) . '</li>';
	$ucs .= '<li>Read: ' . printPerm($cp['read']) . '</li>';
	$ucs .= '<li>Edit Config: ' . printPerm($cp['config']) . '</li>';
	$ucs .= '<li>Add/Manage Cron: ' . printPerm($cp['cron']) . '</li>';
	$ucs .= '</ul>';
}

Yii::app()->clientScript->registerScript(
   'myHideEffect',
   '$(".flash-success").animate({opacity: 1.0}, 6000).fadeOut("slow");',
   CClientScript::POS_READY
);
?>

<?php if(Yii::app()->user->hasFlash('success')):?>
    <div class="flash-success">
        <?php echo Yii::app()->user->getFlash('success'); ?>
    </div>
<?php endif; ?>

<fieldset class="ui-widget ui-widget-content ui-corner-all">
<legend class="ui-widget ui-widget-header ui-corner-all">View User <?php echo $model->username; ?></legend>



	<b><?php echo CHtml::encode($model->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($model->id), array('view', 'id'=>$model->id)); ?>
	<br />

	<b><?php echo CHtml::encode($model->getAttributeLabel('username')); ?>:</b>
	<?php echo CHtml::encode($model->username); ?>
	<br />
	
	<b><?php echo CHtml::encode($model->getAttributeLabel('email')); ?>:</b>
	<?php echo CHtml::encode($model->email); ?>
	<br />

	<b><?php echo CHtml::encode($model->getAttributeLabel('role')); ?>:</b>
	<?php echo CHtml::encode(Lookup::item("UserRole", $model->role)); ?>
	<br />

	<b>Groups: </b>
	<?php echo $ugs; ?>
	<br />
	
	<b>Crawler Permissions: </b><br /><br />
	<?php echo $ucs; ?>
	<br />


</fieldset>
