<?php

// If no environment info or no system settings, go install
if (file_exists(dirname(__FILE__).'/protected/config/db.php') === false 
	|| file_exists(dirname(__FILE__).'/protected/config/db_web_manager.php') === false) {
    header('location:install.php');
}

// change the following paths if necessary
$yii=dirname(__FILE__).'/support-files/framework/yii.php';
$config=dirname(__FILE__).'/protected/config/main.php';

// remove the following lines when in production mode
define('YII_DEBUG',true);
// specify how many levels of call stack should be shown in each log message
defined('YII_TRACE_LEVEL') or define('YII_TRACE_LEVEL',3);

require_once($yii);
Yii::createWebApplication($config)->run();
