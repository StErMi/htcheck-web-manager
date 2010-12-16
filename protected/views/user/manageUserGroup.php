<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/gridView/styles.css" />

<?php
$this->breadcrumbs=array(
	'Users'=>array('index'),
	$model->username=>array('view','id'=>$model->id),
	'Manage User Group',
);

$this->menu=array(
	array('label'=>'Create User', 'url'=>array('create')),
	array('label'=>'Update User', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'View User', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage User', 'url'=>array('admin')),
	array('label'=>'Create Group', 'url'=>array('group/create')),
	array('label'=>'Manage Group', 'url'=>array('group/admin')),
);
?>

<h1>Manage Groups of User: <?php echo $model->username; ?></h1>

<p>
You may optionally enter a comparison operator (<b>&lt;</b>, <b>&lt;=</b>, <b>&gt;</b>, <b>&gt;=</b>, <b>&lt;&gt;</b>
or <b>=</b>) at the beginning of each of your search values to specify how the comparison should be done.
</p>

<div class="flash-success" id="hidden_update_result" style="display:none;"></div>

<fieldset class="ui-widget ui-widget-content ui-corner-all"> 
<legend class="ui-widget ui-widget-header ui-corner-all">List of Groups related to the User</legend>
<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'user-grid-added',
	'ajaxUpdate'=>'user-grid-not-added, user-grid-added',
	'afterAjaxUpdate'=>'
				function(id, data) { 
					var divResult = $("#hidden_update_result");
					divResult.html("The Relation to the Group has been <b>deleted</b> without problems!");
			 		divResult.show();
			 		divResult.animate({opacity: 1.0}, 4000).fadeOut("slow");
				}
			',
	'dataProvider'=>$groupIN->searchUser( $model->id, true ),
	'filter'=>$groupIN,
	'columns'=>array(
		array(
			'name'=>'title',
			'type'=>'raw',
			'value'=>'CHtml::link( $data->title, $data->url )',
		),
		array(
			'header'=>'Actions',
			'class'=>'CButtonColumn',
			'deleteConfirmation' => 'Are you sure to remove from this group the user '.$model->username.'?',
			'deleteButtonUrl' => 'Yii::app()->createUrl("/group/deleteFromGroup", array("id"=>$data->id, "user_id"=>'.$model->id.'))',
			'deleteButtonLabel' => Yii::t('app', 'remove_from_user_group'), 
			'deleteButtonImageUrl' => Yii::app()->request->baseUrl.'/img/user_delete.png',
			'updateButtonUrl' => 'Yii::app()->createUrl("/group/update", array("id"=>$data->id))',
			'viewButtonUrl' => 'Yii::app()->createUrl("/group/view", array("id"=>$data->id))',
			'template'=>'{view} {update} {delete}',
			
			
		),
	),
)); ?>
</fieldset>

<fieldset class="ui-widget ui-widget-content ui-corner-all"> 
<legend class="ui-widget ui-widget-header ui-corner-all">List of Groups not yet related to the User</legend>
<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'user-grid-not-added',
	'ajaxUpdate'=>'user-grid-not-added, user-grid-added',
	'afterAjaxUpdate'=>'
				function(id, data) { 
					var divResult = $("#hidden_update_result");
					divResult.html("The Relation to the Group has been <b>added</b> without problems!");
			 		divResult.show();
			 		divResult.animate({opacity: 1.0}, 4000).fadeOut("slow");
				}
			',
	'dataProvider'=>$groupOUT->searchUser( $model->id, false ),
	'filter'=>$groupOUT,
	'columns'=>array(
		array(
			'name'=>'title',
			'type'=>'raw',
			'value'=>'CHtml::link( $data->title, $data->url )',
		),
		array(
			'header'=>'Actions',
			'class'=>'CButtonColumn',
			'deleteConfirmation' => 'Are you sure to add this the group the user '.$model->username.'?',
			'deleteButtonUrl' => 'Yii::app()->createUrl("/group/addToGroup", array("id"=>$data->id, "user_id"=>'.$model->id.'))',
			'deleteButtonLabel' => Yii::t('app', 'add_user_to_group'), 
			'deleteButtonImageUrl' => Yii::app()->request->baseUrl.'/img/user_add.png',
			'updateButtonUrl' => 'Yii::app()->createUrl("/group/update", array("id"=>$data->id))',
			'viewButtonUrl' => 'Yii::app()->createUrl("/group/view", array("id"=>$data->id))',
			'template'=>'{view} {update} {delete}',
		),
		
	),
)); ?>
</fieldset>


