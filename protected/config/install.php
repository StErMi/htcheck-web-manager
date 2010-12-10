<?php
// This is the main Web application configuration. Any writable
// CWebApplication properties can be configured here.
return array(
        'basePath'=>dirname(__FILE__).DIRECTORY_SEPARATOR.'..',
        'name'=> 'htCheck Installation',
    	'defaultController' => 'Install/default',

        // preloading 'log' component
        'preload'=>array('log', 'urlManager', 'localeManager'),

        // autoloading model and component classes
		'import'=>array(
			'application.models.*',
			'application.components.*',
		),

        'modules' => array(
                'Install',
        ),

        // application components
        'components'=>array(
                
                'urlManager'=>array(
					
				),
				
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
					),
				),
                'user'=>array(
					// enable cookie-based authentication
					'allowAutoLogin'=>true,
				),
                //Main DB connection
                'db'=>(array()),
        ),

        // application-level parameters that can be accessed
        // using Yii::app()->params['paramName']
        'params'=>array(

        ),
);


