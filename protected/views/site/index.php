<fieldset class="ui-widget ui-widget-content ui-corner-all">
<legend class="ui-widget ui-widget-header ui-corner-all">Latest Logs</legend>
<?php if ( count($logs) == 0 ): ?>
There are currently no logs in the database. You need to start some htcheck craweler!
<?php elseif ( count($logs) > 0 ): ?>
<?php foreach ( $logs as $l ): ?>

<h4><font color="green">Latest Log for <?php echo CHtml::link(CHtml::encode($l->crawler->title), $l->crawler->url); ?></font></h4>

<b><?php echo CHtml::encode($l->getAttributeLabel('version')); ?>:</b>
<?php echo CHtml::encode($l->version); ?>
<br />

<b><?php echo CHtml::encode($l->getAttributeLabel('start_time')); ?>:</b>
<?php echo CHtml::encode($l->start_time); ?>
<br />

<b><?php echo CHtml::encode($l->getAttributeLabel('end_time')); ?>:</b>
<?php echo CHtml::encode($l->end_time); ?>
<br />

<b><?php echo CHtml::encode($l->getAttributeLabel('scheduled_urls')); ?>:</b>
<?php echo CHtml::encode($l->scheduled_urls); ?>
<br />

<b><?php echo CHtml::encode($l->getAttributeLabel('tot_urls')); ?>:</b>
<?php echo CHtml::encode($l->tot_urls); ?>
<br /><br /><br />

<?php endforeach; ?>
<?php else: ?>
Sorry, you need to be logged to see latests logs.
<?php endif;?>
</fieldset>
