<?php
$this->breadcrumbs=array(
	$crawler->title => array('crawler/view', 'id' => $crawler->id),
	'Manage',
);

$this->menu=array(
	array('label'=>'Back to '.$crawler->title, 'url'=>array('crawler/view', 'id' => $crawler->id)),
	array('label'=>'Create new Crontab', 'url'=>array('create', 'crawlerID' => $crawler->id)),
);


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

<div class="flash-success" id="hidden_update_result" style="display:none;">The programmed scan has been <b>deleted</b> without problems!</div>

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'crawler-crontab-grid',
	'dataProvider'=>$model->search( $crawler->id ),
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

