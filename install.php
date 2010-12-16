<?php

try {
	
	$yii=dirname(__FILE__).'/support-files/framework/yii.php';
	$config=dirname(__FILE__).'/protected/config/install.php';
	
	// remove the following line when in production mode
	defined('YII_DEBUG') or define('YII_DEBUG',true);
	defined('YII_TRACE_LEVEL') or define('YII_TRACE_LEVEL',3);
	require_once($yii);     
	
	Yii::createWebApplication($config)->run();

} catch ( CException $e ) {
	echo '<br/><br/><br/><br/><h1>Permission Errors</h1>';
	echo '<font color="red"><b>'.$e->getMessage().'</b></font>';
}
