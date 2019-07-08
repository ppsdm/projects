<?php


$config = [];


if (!YII_ENV_TEST) {
    // configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = [
        'class' => 'yii\debug\Module',
		'allowedIPs' => ['*']
    ];
    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
		'allowedIPs' => ['*']
    ];

    $config['components']['view']['theme'] = [
                'basePath' => '@app/themes/basic',
                'baseUrl' => '@web/themes/basic',
                'pathMap' => [
                    '@app/views' => '@app/themes/basic',
                ],
    ];
	
$config['components']['request'] = [
            'csrfParam' => '_csrf-frontend',
       'csrfCookie' => [
            'name' => '_csrf',
            'path' => '/',
            'domain' => 'localhost',
            //                'domain' => '.ppsdm.com',
        ],
           'enableCookieValidation' => false,
    'enableCsrfValidation' => false,
    'cookieValidationKey' => 'xWZ35QUMzAprRApQdNFjcHkc87gwHhZV',
        ];
		
        $config['components']['user'] = [
            'identityClass' => 'common\models\User',
            'enableAutoLogin' => true,
                            'loginUrl' => 'login',
                        'identityCookie' => [ // <---- here!
                'name' => '_identity',
                'httpOnly' => true,
                'domain' => 'localhost',
              //  'domain' => '.ppsdm.com',
            ],
        ];

} else {
	
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