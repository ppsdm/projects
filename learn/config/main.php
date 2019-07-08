<?php
$params = array_merge(
    require(__DIR__ . '/../../common/config/params.php'),
    require(__DIR__ . '/../../common/config/params-local.php'),
    require(__DIR__ . '/params.php'),
    require(__DIR__ . '/params-local.php')
);

return [
    'id' => 'app-edulab',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log',
      'common\config\settings',
    ],
    //'language' => 'id-ID',
    'controllerNamespace' => 'edulab\controllers',
        'modules' => [

            'social' => [
        // the module class
        'class' => 'kartik\social\Module',
 
        // the global settings for the Disqus widget
        'facebook' => [
            'appId' => '160460681089600',
            'secret' => '8f7424005804ec71d28aa8f6b9bed95d',
        ],

 
 ],
        'learn' => [
            'class' => 'app\modules\learn\Learn',
            // ... other configurations for the module ...
        ],



    ],
    'components' => [
            'view' => [
            'theme' => [
                'basePath' => '@app/themes/edulab',
                'baseUrl' => '@web/themes/edulab',
                'pathMap' => [
                    '@app/views' => '@app/themes/edulab',
                ],
            ],
        ],

  /*      'session' => [
            // this is the name of the session cookie used for login on the frontend
            'name' => 'pao-frontend',
                    'cookieParams' => [
            'path' => '/',
            'domain' => "localhost",
        ],
        ],
        
*/

        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        /*
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
            ],
        ],
        */
        'urlManager' => [
         'enablePrettyUrl' => true,
         'showScriptName' => true,
         'enableStrictParsing' => false,
            'rules' => [
           '<controller:\w+>/<id:\d+>'=>'<controller>/view',
                        '<controller:\w+>/<action:\w+>/<id:\d+>'=>'<controller>/<action>',
                        '<controller:\w+>/<action:\w+>'=>'<controller>/<action>',
            ],
        ],

    'i18n' => [
        'translations' => [
            'app*' => [
                'class' => 'yii\i18n\PhpMessageSource',
                //'basePath' => '@app/messages',
                //'sourceLanguage' => 'en-US',
                'fileMap' => [
                    'app' => 'app.php',
                   // 'app/error' => 'error.php',
                ],
            ],
        ],
    ],
    ],
    'params' => $params,
];
