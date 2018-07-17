<?php

$params = require __DIR__ . DIRECTORY_SEPARATOR . 'params.php';
$db = require __DIR__ . DIRECTORY_SEPARATOR . 'db.php';
$redis = require __DIR__ . DIRECTORY_SEPARATOR . 'redis.php';

$config = [
    'id' => 'basic',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
    ],
    'components' => [
        'request' => [
            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
            'cookieValidationKey' => '-q-wGZDk_CxYnjjuEmIsyJUNa2PLdT5N',
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'user' => [
            'identityClass' => 'app\common\models\User',
            'enableAutoLogin' => true,
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            'viewPath' => '@common/views/mail',
            // send all mails to a file by default. You have to set
            // 'useFileTransport' to false and configure a transport
            // for the mailer to send real emails.
            //
            // go into effect when env is prod
            'useFileTransport' => !in_array(YII_ENV, ['prod']),
            'transport' => [
                'class' => 'Swift_SmtpTransport',
                'username' => env('MAIL_USERNAME', ''),
                'password' => env('MAIL_PASSWORD', ''),
                'host' => env('MAIL_HOST', ''),
                'port' => env('MAIL_PORT', ''),
                'encryption' => env('MAIL_PORT', 'ssl'),
            ],
            'messageConfig' => [
                'charset' => 'UTF-8',
                'from' => [env('MAIL_ADMIN', '') => '邮件预警']
            ],
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
        'db' => $db,
        'redis' => $redis,
    ],
    'params' => $params,
];

if (YII_ENV_DEV || 'cli' !== php_sapi_name()) {
    // configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = [
        'class' => 'yii\debug\Module',
        // uncomment the following to add your IP if you are not connecting from localhost.
        'allowedIPs' => ['127.0.0.1', '::1'],
    ];

    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
        // uncomment the following to add your IP if you are not connecting from localhost.
        //'allowedIPs' => ['127.0.0.1', '::1'],
    ];
}

return $config;
