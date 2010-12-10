<?php
$this->breadcrumbs=array(
	'Servers',
);

$this->menu=array(
	array('label'=>'Create Server', 'url'=>array('create')),
	array('label'=>'Manage Server', 'url'=>array('admin')),
);
?>

<h1>Servers</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
