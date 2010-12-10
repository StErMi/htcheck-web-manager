<?php
$this->breadcrumbs=array(
	'Crawlers',
	'Manage',
);

if ( User::checkRole(User::ROLE_ADMIN) ) {
	$this->menu=array(
		array('label'=>'Create Crawler', 'url'=>array('create')),
	);
}
?>

<fieldset class="ui-widget ui-widget-content ui-corner-all">
<legend class="ui-widget ui-widget-header ui-corner-all">Manage Crawlers</legend>

<p>
You may optionally enter a comparison operator (<b>&lt;</b>, <b>&lt;=</b>, <b>&gt;</b>, <b>&gt;=</b>, <b>&lt;&gt;</b>
or <b>=</b>) at the beginning of each of your search values to specify how the comparison should be done.
</p>



<?php 

$_POST['uperm'] = $user->getPermissions();

function checkPermission ( $crawlerID, $pType, $user=null ) {
	
	$p = $_POST['uperm'][$crawlerID];
	return $p[$pType];
}

$this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'crawler-grid',
	'dataProvider'=>$model->search( $user ),
	'filter'=>$model,
	'columns'=>array(
		array(
			'name'=>'title',
			'type'=>'raw',
			'value'=>'CHtml::link( CHtml::encode($data->title), $data->url)',
		),
		'start_url',
		'db_name',
		'db_name_prepend',
		array(
			'class'=>'CButtonColumn',
			//updateButtonOptions
			'template'=>'{view} {update} {delete} {addCron} {manageCron} {addUser} {manageUser}',
			'buttons' => array(
				'view'=> array(
					'visible'=>'checkPermission( $data->id, "read" ) ',
				),
				'update'=> array(
					'visible'=>'checkPermission( $data->id, "admin" ) ',
				),
				'delete'=> array(
					'visible'=>'checkPermission( $data->id, "admin" ) ',
				),
				'addCron' => array(
				    'label'=>'Add Programmed / Manual Scan',
				    'url'=> 'Yii::app()->createUrl("/crawlerCrontab/create", array("crawlerID"=>$data->id))',
				    'imageUrl'=>Yii::app()->request->baseUrl.'/img/clock_add.png',
				    'visible'=>'checkPermission( $data->id, "cron" ) ',
				),
				'manageCron' => array(
				    'label'=>'Manage Programmed / Manual Scan',
				    'url'=> 'Yii::app()->createUrl("/crawlerCrontab/admin", array("crawlerID"=>$data->id))',
				    'imageUrl'=>Yii::app()->request->baseUrl.'/img/clock_edit.png',
				    'visible'=>'checkPermission( $data->id, "cron" ) ',
				),
				'addUser' => array(
				    'label'=>'Add User to Crawler Permissions',
				    'url'=> 'Yii::app()->createUrl("/userCrawler/create", array("crawlerID"=>$data->id))',
				    'imageUrl'=>Yii::app()->request->baseUrl.'/img/user_add.png',
					'visible'=>'checkPermission( $data->id, "admin" ) ',
				),
				'manageUser' => array(
				    'label'=>'Manage Crawler\'s Users',
				    'url'=> 'Yii::app()->createUrl("/userCrawler/admin", array("crawlerID"=>$data->id))',
				    'imageUrl'=>Yii::app()->request->baseUrl.'/img/user_edit.png',
					'visible'=>'checkPermission( $data->id, "admin" ) ',
				),
			),
			'htmlOptions'=>array('width'=>140),		
		
			
		),
	),
)); ?>

</fieldset>

