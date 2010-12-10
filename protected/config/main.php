<?php

// uncomment the following to define a path alias
// Yii::setPathOfAlias('local','path/to/local-folder');

// This is the main Web application configuration. Any writable
// CWebApplication properties can be configured here.
return array(
	'basePath'=>dirname(__FILE__).DIRECTORY_SEPARATOR.'..',
	'name'=>'ht://Check WebManager',

	'language' => 'en',
	'sourceLanguage' => 'xx',

	// preloading 'log' component
	'preload'=>array('log'),

	// autoloading model and component classes
	'import'=>array(
		'application.models.*',
		'application.components.*',
	),

	'modules'=>array(
		// uncomment the following to enable the Gii tool
		/*
		'gii'=>array(
			'class'=>'system.gii.GiiModule',
			'password'=>'Enter Your Password Here',
		),
		*/
	),

	// application components
	'components'=>array(
		'user'=>array(
			// enable cookie-based authentication
			'allowAutoLogin'=>true,
		),
		// uncomment the following to enable URLs in path-format
		
		'urlManager'=>array(
			'urlFormat'=>'path',
			//'showScriptName' => false,
			'urlSuffix' => '.html',
			'rules'=>array(
				'crawler/<id:\d+>/<title:.*?>'=>'crawler/view',
				'vod/<id:\d+>/<title:.*?>'=>'vod/view',
				'group/<id:\d+>/<title:.*?>'=>'group/view',
				'user/<id:\d+>/<username:.*?>'=>'user/view',
				'<controller:\w+>/<id:\d+>'=>'<controller>/view',
				'<controller:\w+>/<action:\w+>/<id:\d+>'=>'<controller>/<action>',
				'<controller:\w+>/<action:\w+>'=>'<controller>/<action>',
			),
		),
		
		// FOR TESTING ON DEVISE LAB
		/*'db'=>array(
			'connectionString' => 'mysql:host=localhost;dbname=htcheck_devise_new',
			'emulatePrepare' => true,
			'username' => 'htcheck',
			'password' => 'htcheck',
			'charset' => 'utf8',
		),*/
		
		
		// FOR TESTING ON HOME LAB		
		'db'=>require(dirname(__FILE__).'/db.php'),
		'db_web_manager'=>require(dirname(__FILE__).'/db_web_manager.php'),
		
		
		
		'errorHandler'=>array(
			// use 'site/error' action to display errors
            'errorAction'=>'site/error',
        ),
		'log'=>array(
			'class'=>'CLogRouter',
			'routes'=>array(
				array(
					'class'=>'CFileLogRoute',
					'levels'=>'error, warning',
				),
				// uncomment the following to show log messages on web pages
				/*
				array(
					'class'=>'CWebLogRoute',
				),
				*/
			),
		),
	),

	// application-level parameters that can be accessed
	// using Yii::app()->params['paramName']
	'params'=>array(
		// this is used in contact page
		'adminEmail'=>'webmaster@example.com',
		'itemsPerPage'=>50,
		'itemsPerPageUser'=>15,
		'itemsPerPageGroup'=>15,
	),
);
