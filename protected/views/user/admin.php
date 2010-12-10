<?php
$this->breadcrumbs=array(
	'Users',
	'Manage',
);

$this->menu=array(
	array('label'=>'Create User', 'url'=>array('create')),
);


?>

<fieldset class="ui-widget ui-widget-content ui-corner-all">
<legend class="ui-widget ui-widget-header ui-corner-all">Manage Users</legend>


<p>
You may optionally enter a comparison operator (<b>&lt;</b>, <b>&lt;=</b>, <b>&gt;</b>, <b>&gt;=</b>, <b>&lt;&gt;</b>
or <b>=</b>) at the beginning of each of your search values to specify how the comparison should be done.
</p>



<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'user-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'username',
		array(
			'name'=>'role',
			'value'=>'Lookup::item("UserRole", $data->role)',
			'filter'=>Lookup::items('UserRole'),
		),
		array(
			'name'=>'language',
			'value'=>'Lookup::item("UserLanguage", $data->language)',
			'filter'=>Lookup::items('UserLanguage'),
		),
		'email',
		array(
			'header'=>'Actions',
			'class'=>'CButtonColumn',
			'template'=>'{view} {update} {delete} {manageUserGroup}',
			'buttons' => array(
				'manageUserGroup' => array(
				    'label'=>Yii::t('app', 'manage_user_group'),     // text label of the button
				    'url'=> 'Yii::app()->createUrl("/user/manageUserGroup", array("id"=>$data->id))',    // a PHP expression for generating the URL of the button
				    'imageUrl'=>Yii::app()->request->baseUrl.'/img/user_add.png',  // image URL of the button. If not set or false, a text link is used
				    'visible'=>'1',   // a PHP expression for determining whether the button is visible
				),
			),
			'htmlOptions'=>array('width'=>95),		
		
			
		),
	),
)); ?>

</fieldset>
