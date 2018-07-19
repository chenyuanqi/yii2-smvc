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
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        // 权限管理
        // authManager 有 PhpManager 和 DbManager 两种方式,    
        // PhpManager 将权限关系保存在文件里,这里使用的是 DbManager 方式,将权限关系保存在数据库.  
        // 
        // 数据迁移命令
        //     ./yii migrate --migrationPath=@yii/rbac/migrations/
        // 数据表的命名
        //     auth_item：用于存储角色、权限和路由
        //     auth_item_child：角色-权限的关联表
        //     auth_assignment：用户-角色的关联表  
        "authManager" => [        
            "class" => 'yii\rbac\DbManager',
        ],
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            'viewPath' => '@common/views/mail',
            // send all mails to a file by default. You have to set
            // 'useFileTransport' to false and configure a transport
            // for the mailer to send real emails.
            //
            // go into effect when env is product.
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
        'allowedIPs' => ['127.0.0.1', '::1'],
    ];
}

return $config;
