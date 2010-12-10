<?php
$this->breadcrumbs=array(
	'Groups',
	'Manage',
);

$this->menu=array(
	array('label'=>'Create Group', 'url'=>array('create')),
	
);


?>

<fieldset class="ui-widget ui-widget-content ui-corner-all">
<legend class="ui-widget ui-widget-header ui-corner-all">Manage Groups</legend>


<p>
You may optionally enter a comparison operator (<b>&lt;</b>, <b>&lt;=</b>, <b>&gt;</b>, <b>&gt;=</b>, <b>&lt;&gt;</b>
or <b>=</b>) at the beginning of each of your search values to specify how the comparison should be done.
</p>



<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'group-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		array(
			'name'=>'title',
			'type'=>'raw',
			'value'=>'CHtml::link( CHtml::encode($data->title), $data->url)',
		),
		array(
			'class'=>'CButtonColumn',
			'template'=>'{view} {update} {delete} {manageUser}',
			'buttons' => array(
				'manageUser' => array(
				    'label'=>'Manage User',
				    'url'=> 'Yii::app()->createUrl("/group/manageUser", array("id"=>$data->id))',
				    'imageUrl'=>Yii::app()->request->baseUrl.'/img/user_add.png',
				),
			),
			'htmlOptions'=>array('width'=>85),		
		
			
		),
	),
)); ?>

</fieldset>
