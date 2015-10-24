<?php

$params = require(__DIR__ . '/params.php');

$config = [
    'id' => 'basic',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'components' => [
        'request' => [
            'cookieValidationKey' => 'ZBrDPCnp0K3ZwaRQgbSSb9RDKNOUaWf7',
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'user' => [
            'identityClass' => 'app\models\entity\User',
            'enableAutoLogin' => true,
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            //'useFileTransport' => true,
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'db' => require(__DIR__ . '/db.php'),
		'authManager' => [
			'class' => 'yii\rbac\DbManager',
			'defaultRoles' => ['admin', 'moderator', 'user'],
		],
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
				
				//'site/captcha' => 'site/default/captcha',
				
				'news/<page:\d+>' => 'news/default/index',
				'news/<slug:[\w-]+>' => 'news/default/view',
				
				'<module:\w+>/'        		=> '<module>/default/index',
				'<module:\w+>/<action:[\w-]+>' => '<module>/default/<action>',
				
				
				//'<module:\w+>/'        							=> '<module>/default/index',
				//'<module:\w+>/<slug:[\w-]+>/'        		    => '<module>/default/view',
				//'<module:\w+>/<controller:\w+>/'        		=> '<module>/<controller>/index',
				//'<module:\w+>/<controller:\w+>/<action:\d+>'    => '<module>/<controller>/<action>',
            ],
        ]
    ],
	'modules' => [
		'site' => [
            'class' => 'app\modules\site\Site',
        ],
		'user' => [
            'class' => 'app\modules\user\User',
        ],
		'news' => [
            'class' => 'app\modules\news\News',
        ],
	],
    'params' => $params,
];

if (YII_ENV_DEV) {
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = [
        'class' => 'yii\debug\Module',
    ];

    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
    ];
}

return $config;
