<?php

// uncomment the following to define a path alias
// Yii::setPathOfAlias('local','path/to/local-folder');

// This is the main Web application configuration. Any writable
// CWebApplication properties can be configured here.
return array(
	'basePath'=>dirname(__FILE__).DIRECTORY_SEPARATOR.'..',
	'name'=>'Путь к финансовому успеху',

	// preloading 'log' component
	'preload'=>array(),

	// autoloading model and component classes
	'import'=>array(
		'application.models.*',
                'application.models.tools.*',
                'application.models.events.*',
		'application.components.*',
	),

	'modules'=>array(
		// uncomment the following to enable the Gii tool
		'gii'=>array(
			'class'=>'system.gii.GiiModule',
			'password'=>'12345',
			// If removed, Gii defaults to localhost only. Edit carefully to taste.
			//'ipFilters'=>array('10.10.3.185','::1'),
		),
	),

	// application components
	'components'=>array(
		'user'=>array(
			// enable cookie-based authentication
			'allowAutoLogin'=>false,
		),
		// uncomment the following to enable URLs in path-format
		
		'urlManager'=>array(
			'urlFormat'     =>'path',
                        //'showScriptName'=>false,
			/*'rules'=>array(
				'<controller:\w+>/<id:\d+>'=>'<controller>/view',
				'<controller:\w+>/<action:\w+>/<id:\d+>'=>'<controller>/<action>/<id:\d+>',
				'<controller:\w+>/<action:\w+>'=>'<controller>/<action>',
			),*/
		),
                /*
		'db'=>array(
			'connectionString' => 'sqlite:'.dirname(__FILE__).'/../data/testdrive.db',
		),
		// uncomment the following to use a MySQL database
		*/
		'db'=>array(
			'connectionString'  => 'mysql:host=localhost;dbname=pfudb',
			'emulatePrepare'    => true,
			'username'          => 'pfuusr',
			'password'          => 'd89s3fs2SA',
			'charset'           => 'utf8',
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
				// uncomment the following to show log messages on web pages

				array(
					'class'=>'CWebLogRoute',
				),

			),
		),
	),

	// application-level parameters that can be accessed
	// using Yii::app()->params['paramName']
	'params'=>array(
		// this is used in contact page
		'adminEmail'=>'vuylov@gmail.com',
                'income'    => '10000',
                'prestige'  => '0',
                'levels'    => array(
                    array(0, 1000, 'intro.mp4'),
                    array(1001, 5000, 'level_1.mp4'),
                    array(5001, 20000, 'level_2.mp4'),
                    array(20001, 50000, 'level_3.mp4'),
                    array(50001, 163999, 'level_4.mp4'),
                    array(164000, 200000, 'win.mp4'),
                ),
                'video_game_over' => 'fail.mp4',
                'insure_period'   => 12,
                'insure_rate'     => 0.8,  
	),
);