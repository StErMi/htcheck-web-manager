<?php
$this->breadcrumbs=array(
	'Groups',
	$model->title=>array('view','id'=>$model->id, 'title' => $model->title),
	'Manage User',
);

$this->menu=array(
	array('label'=>'Manage Groups', 'url'=>array('admin')),
	array('label'=>'Create Group', 'url'=>array('create')),
);

Yii::app()->clientScript->registerScript(
   'myHideEffect',
   '$(".flash-success").animate({opacity: 1.0}, 6000).fadeOut("slow");',
   CClientScript::POS_READY
);


?>



<h1>Manage Users of Group: <?php echo $model->title; ?></h1>

<?php if(Yii::app()->user->hasFlash('success')):?>
    <div class="flash-success">
        <?php echo Yii::app()->user->getFlash('success'); ?>
    </div>
<?php endif; ?>

<p>
You may optionally enter a comparison operator (<b>&lt;</b>, <b>&lt;=</b>, <b>&gt;</b>, <b>&gt;=</b>, <b>&lt;&gt;</b>
or <b>=</b>) at the beginning of each of your search values to specify how the comparison should be done.
</p>

<div class="flash-success" id="hidden_update_result" style="display:none;"><b>The operation finished without problems!</b></div>

<fieldset class="ui-widget ui-widget-content ui-corner-all"> 
<legend class="ui-widget ui-widget-header ui-corner-all">User Added</legend>

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'user-grid-added',
	'ajaxUpdate'=>'user-grid-added, user-grid-not-added',
	'afterAjaxUpdate'=>'
							function(id, data) { 
								var divResult = $("#hidden_update_result");
						 		divResult.show();
						 		divResult.animate({opacity: 1.0}, 4000).fadeOut("slow");
							}
						',
	'template'=>'{items}',
	'dataProvider'=>$userIN->searchGroup( $model->id, true ),
	'filter'=>$userIN,
	'columns'=>array(
		array( 
			'name'=>'username',
			'type'=>'raw',
			'value' => 'CHtml::link(CHtml::encode($data->username), $data->url)',
		),
		array(
			'header'=>'Actions',
			'class'=>'CButtonColumn',
			'deleteConfirmation' => 'Are you sure to remove the user from the group '.$model->title.'?',
			'deleteButtonUrl' => 'Yii::app()->createUrl("/group/deleteFromGroup", array("id"=>'.$model->id.', "user_id"=>$data->id))',
			'deleteButtonLabel' => Yii::t('app', 'remove_from_user_group'), 
			'deleteButtonImageUrl' => Yii::app()->request->baseUrl.'/img/user_delete.png',
			'updateButtonUrl' => 'Yii::app()->createUrl("/user/update", array("id"=>$data->id, "username"=>$data->username))',
			'viewButtonUrl' => 'Yii::app()->createUrl("/user/view", array("id"=>$data->id, "username"=>$data->username))',
			'template'=>'{view} {update} {delete}',
			
			
		),
	),
)); ?>
</fieldset>

<fieldset class="ui-widget ui-widget-content ui-corner-all"> 
<legend class="ui-widget ui-widget-header ui-corner-all">Users not yet added</legend>

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'user-grid-not-added',
	'template'=>'{items}',
	'ajaxUpdate'=>'user-grid-added, user-grid-not-added',
	'afterAjaxUpdate'=>'
							function(id, data) { 
								var divResult = $("#hidden_update_result");
						 		divResult.show();
						 		divResult.animate({opacity: 1.0}, 4000).fadeOut("slow");
							}
						',
	'dataProvider'=>$userIN->searchGroup( $model->id, false ),
	'filter'=>$userIN,
	'columns'=>array(
		array( 
			'name'=>'username',
			'type'=>'raw',
			'value' => 'CHtml::link(CHtml::encode($data->username), $data->url)',
		),
		array(
			'header'=>'Actions',
			'class'=>'CButtonColumn',
			'deleteConfirmation' => 'Are you sure to add the user to the group '.$model->title.'?',
			'deleteButtonUrl' => 'Yii::app()->createUrl("/group/addToGroup", array("id"=>'.$model->id.', "user_id"=>$data->id))', 
			'deleteButtonLabel' => Yii::t('app', 'add_user_to_group'), 
			'deleteButtonImageUrl' => Yii::app()->request->baseUrl.'/img/user_add.png',
			'updateButtonUrl' => 'Yii::app()->createUrl("/user/update", array("id"=>$data->id, "username"=>$data->username))',
			'viewButtonUrl' => 'Yii::app()->createUrl("/user/view", array("id"=>$data->id, "username"=>$data->username))',
			'template'=>'{view} {update} {delete}',
		),
		
	),
)); ?>
</fieldset>

