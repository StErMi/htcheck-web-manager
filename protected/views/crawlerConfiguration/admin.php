<?php
$this->breadcrumbs=array(
	'Crawler Configurations',
	'Manage',
);

if ( User::checkRole(User::ROLE_ADMIN) ) {
	$this->menu=array(
		array('label'=>'Create Configuration', 'url'=>array('create')),
	);
}
?>

<fieldset class="ui-widget ui-widget-content ui-corner-all">
<legend class="ui-widget ui-widget-header ui-corner-all">Manage Crawler Configurations</legend>

<p>
You may optionally enter a comparison operator (<b>&lt;</b>, <b>&lt;=</b>, <b>&gt;</b>, <b>&gt;=</b>, <b>&lt;&gt;</b>
or <b>=</b>) at the beginning of each of your search values to specify how the comparison should be done.
</p>

<div class="flash-success" id="hidden_update_result" style="display:none;">The Configuration Layout has been <b>deleted</b> without problems!</div>

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'crawler-grid',
	'dataProvider'=>$model->search(),
	'afterAjaxUpdate'=>'
						function(id, data) { 
							var divResult = $("#hidden_update_result");
					 		divResult.show();
					 		divResult.animate({opacity: 1.0}, 4000).fadeOut("slow");
						}
					',
	'filter'=>$model,
	'columns'=>array(
		array(
			'name'=>'title',
			'type'=>'raw',
			'value'=>'CHtml::link( CHtml::encode($data->title), $data->url)',
		),
		array(
			'class'=>'CButtonColumn',
		),
	),
)); ?>

</fieldset>

