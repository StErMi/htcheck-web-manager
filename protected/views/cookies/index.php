<?php
$this->breadcrumbs=array(
	'Cookies',
);

$this->menu=array(
	array('label'=>'Create Cookies', 'url'=>array('create')),
	array('label'=>'Manage Cookies', 'url'=>array('admin')),
);
?>

<h1>Cookies</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
