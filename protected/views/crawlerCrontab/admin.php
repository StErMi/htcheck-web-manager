<?php
$this->breadcrumbs=array(
	$crawler->title => array('crawler/view', 'id' => $crawler->id),
	'Manage',
);

$this->menu=array(
	array('label'=>'Back to '.$crawler->title, 'url'=>array('crawler/view', 'id' => $crawler->id)),
	array('label'=>'Create new Crontab', 'url'=>array('create', 'crawlerID' => $crawler->id)),
);


?>

<fieldset class="ui-widget ui-widget-content ui-corner-all"> 
<legend class="ui-widget ui-widget-header ui-corner-all">Crawler Scans Queued</legend>

<?php if ( count($crawler->queue) > 0 ): ?>
<ul>
<?php foreach ( $crawler->queue as $q ): ?>
<li>Queue ID #<?php echo $q->id; ?>, added by user <?php echo CHtml::link(CHtml::encode($q->user->username), $q->user->url); ?></li>
<?php endforeach; ?>
</ul>
<?php echo CHtml::link('Add new one!', array('create', 'crawlerID'=>$crawler->id) ); ?>
<?php else: ?>
No manually added scans found. <?php echo CHtml::link('Add new one!', array('create', 'crawlerID'=>$crawler->id) ); ?>
<?php endif; ?>

</fieldset>


<fieldset class="ui-widget ui-widget-content ui-corner-all"> 
<legend class="ui-widget ui-widget-header ui-corner-all">Manage Crawler Cron</legend> 

<p>
You may optionally enter a comparison operator (<b>&lt;</b>, <b>&lt;=</b>, <b>&gt;</b>, <b>&gt;=</b>, <b>&lt;&gt;</b>
or <b>=</b>) at the beginning of each of your search values to specify how the comparison should be done.
</p>


<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'crawler-crontab-grid',
	'dataProvider'=>$model->search( $crawler->id ),
	'filter'=>$model,
	'columns'=>array(
		array(
			'name'=>'minute',
			'header'=>'Cronjob Date & Time',
			'value'=>'$data->toString()',
			'filter'=>false,
		),
		array(
			'header'=>'Actions',
			'class'=>'CButtonColumn',
			'template'=>'{update} {delete}',
		),
	),
)); ?>

</fieldset>

