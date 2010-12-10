<?php
$this->breadcrumbs=array(
	Yii::app()->session['_db'] => array('htCheck/index'),
	'Accessibility Checks Search'=>array('search'),
	$model->IDCheck,
);

$ops = array();
$ops[] = array('label'=> 'Back to Crawler Index', 'url'=>array('htCheck/index'));
$ops[] = array('label'=> 'View LOGs', 'url'=>array('crawlerLog/index', 'crawlerID' => Yii::app()->session['_crawler_id']));
$ops[] = array('label'=>'Url List', 'url'=>array('url/index'));
$ops[] = array('label'=>'Search URLs', 'url'=>array('url/search'));
$ops[] = array('label'=>'Search Links', 'url'=>array('link/search'));
$ops[] = array('label'=>'Search Accessibility Checks', 'url'=>array('accessibility/search'));

$u = User::getMe();
$permissions = $u->getCrawlersPermissions( Yii::app()->session['_crawler_id'] );
if ( $permissions['config'] ) $ops[] = array('label'=>'Update Config', 'url'=>array('crawler/update', 'id'=>Yii::app()->session['_crawler_id']));
if ( $permissions['cron'] ) $ops[] = array('label'=>'Manage Crontab', 'url'=>array('crawlerCrontab/admin', 'crawlerID' => Yii::app()->session['_crawler_id']));

if ( $displayOps !== null ) {
	$ops[] = array('label'=>'Show the HTML source of this URL', 'url'=>array('url/viewSource', 'id'=>$model->IDUrl, 'RowNumber'=>$model->hs->Row, '#'=>$model->hs->Row) );
	$ops[] = array('label'=>'View the URL', 'url'=>array('url/view', 'id'=>$model->IDUrl) );
}

$this->menu=$ops;

?>

<fieldset class="ui-widget ui-widget-content ui-corner-all"> 
<legend class="ui-widget ui-widget-header ui-corner-all">Information regarding the accessibility error</legend> 

<?php if ( !empty($model->hs) && !empty($model->hs->Statement) ):?>
<b><?php echo CHtml::encode($model->getAttributeLabel('hs.Statement')); ?>:</b>
<?php echo CHtml::encode($model->hs->Statement); ?>
<br />
<?php endif; ?>

<?php if ( !empty($model->ha) && !empty($model->ha->Attribute) ):?>
<b><?php echo CHtml::encode($model->getAttributeLabel('ha.Attribute')); ?>:</b>
<?php echo CHtml::encode($model->ha->Attribute); ?>
<br />
<?php endif; ?>

<?php if ( !empty($model->hs) && !empty($model->hs->Row) ):?>
<b><?php echo CHtml::encode($model->getAttributeLabel('hs.Row')); ?>:</b>
<?php echo CHtml::encode($model->hs->Row); ?>
<br />
<?php endif; ?>

<b><?php echo CHtml::encode($model->getAttributeLabel('url.Url')); ?>:</b>
<?php echo CHtml::encode($model->url->Url); ?>
<br />

<b><?php echo CHtml::encode($model->getAttributeLabel('TagPosition')); ?>:</b>
<?php echo CHtml::encode($model->TagPosition); ?>
<br />

<b><?php echo CHtml::encode($model->getAttributeLabel('AttrPosition')); ?>:</b>
<?php echo CHtml::encode($model->AttrPosition); ?>
<br /><br />

<h3>Error Information</h3>

<b>Error:</b>
<?php echo CHtml::encode($model->getErrorErr()); ?>
<br />

<b>OAC description:</b>
<?php echo CHtml::encode($model->getErrorDesc()); ?>
<br />

<b>How to repair:</b>
<?php echo CHtml::encode($model->getErrorRepair()); ?>
<br />


</fieldset>
