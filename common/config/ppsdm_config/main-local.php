<?php
return [
    'components' => [
  /* 
         'db' => [
            'class' => 'yii\db\Connection',
            'dsn' => 'mysql:host=localhost;dbname=ppsdm_paodb',
            'username' => 'root',
            'password' => '',
            'charset' => 'utf8',
        ], 
    */                 
 
           
        'db' => [
            'class' => 'yii\db\Connection',
            'dsn' => 'mysql:host=aws.ppsdm.com;dbname=ppsdm_sekab_paodb',
            'username' => 'ppsdm',
            'password' => 'ppsdm-mysql',
            'charset' => 'utf8',
        ], 

		

        'taodb' => [
        
            'class' => 'yii\db\Connection',
            'dsn' => 'mysql:host=localhost;dbname=taodb',
            'username' => 'root',
            'password' => '',
            'charset' => 'utf8',
        ],
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            'viewPath' => '@common/mail',
            // send all mails to a file by default. You have to set
            // 'useFileTransport' to false and configure a transport
            // for the mailer to send real emails.
            'useFileTransport' => false,
            'transport' => [
              'class' => 'Swift_SmtpTransport',
              'host' => 'smtp.gmail.com',
              'username' => 'gamantha.adhiguna@gmail.com',
              'password' => 'gamantha123!',
              'port' => '465',
              'encryption' => 'ssl',
          ],
        ],
    ],
];
