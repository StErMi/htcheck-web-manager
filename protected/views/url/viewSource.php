
<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/greed_styles.css" />

<?php
$this->breadcrumbs=array(
	Yii::app()->session['_db'] => array('htCheck/index'),
	'URL List' => array('url/index'),
	$model->Url => array('view', 'id'=>$model->IDUrl),
	'View Source',
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

$this->menu=$ops;

?>


<div class="grid-view" id="url-grid-HTTP-results">
<table class="items">
<?php
$RowNumber = $_GET['RowNumber'];

	$row_number = 1;
    $oldpos=0;

	while ( $newtok = substr($model->Contents, $oldpos) )
	{
       $newpos = strpos($newtok, "\n");
       if ($newpos)
          $str_row = CHtml::encode(substr($newtok, 0, $newpos));
       else
          $str_row = '&nbsp;';

       $oldpos += $newpos + 1;

       if ($row_number == $RowNumber)
          $trclass='row';
       else
          ($row_number % 2)? $trclass='odd':$trclass='even';

?>
 <tr class="<?php echo $trclass; ?>">
 <td><div align="center"><a name="<?php echo $row_number; ?>"><?php echo $row_number; ?></a></div></td>
 <td><?php echo $str_row; ?></td>
 </tr>
<?php
		++$row_number;
	}
?>
</table>
</div>

