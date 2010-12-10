<?php

defined('YII_DEBUG') or define('YII_DEBUG',true);
// include Yii bootstrap file
require_once(dirname(__FILE__).'/../../yii/framework/yii.php');
// create application instance and run
$configFile=dirname(__FILE__).'/../protected/config/main.php';
Yii::createConsoleApplication($configFile)->run();
