<?php

$params = require __DIR__ . DIRECTORY_SEPARATOR . 'params.php';
$db = require __DIR__ . DIRECTORY_SEPARATOR . 'db.php';
$redis = require __DIR__ . DIRECTORY_SEPARATOR . 'redis.php';

$exceptException = [
    'yii\\web\\HttpException:400',                                  //错误的请求 400
    'yii\\web\\HttpException:401',                                  //鉴权失败 401
    'yii\\web\\HttpException:403',                                  //没有访问资源的权限 403
    'yii\\web\\HttpException:404',                                  //页面未找到 404
    'yii\\web\\HttpException:405',                                  //请求方式不正确 405
    'yii\\web\\HttpException:410',                                  //资源不在可用 410
    'yii\\web\\HttpException:415',                                  //对于当前请求的方法和所请求的资源，请求中提交的实体并不是服务器中所支持的格式，因此请求被拒绝 415
    'yii\\web\\HttpException:422',                                  //请求格式正确, 但是由于含有语义错误 422
    'yii\\web\\HttpException:429',                                  //太多请求 429
    'yii\base\UserException',
];

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
            // 'viewPath' => '@common/views/mail',
            // send all mails to a file by default. You have to set
            // 'useFileTransport' to false and configure a transport
            // for the mailer to send real emails.
            //
            // go into effect when env is product.
            'useFileTransport' => !in_array(YII_ENV, ['sandbox', 'prod']), //只在生产环境下才生效，即值为 false 生效
            'transport' => [
                'class' => 'Swift_SmtpTransport',
                'username' => env('MAIL_USERNAME', 'supervisory@xxx.com'),
                'password' => env('MAIL_PASSWORD', 'xxx'),
                'host' => env('MAIL_HOST', 'smtp.exmail.qq.com'),
                'port' => env('MAIL_PORT', '465'),
                'encryption' => env('MAIL_SSL', 'ssl'),
            ],
            'messageConfig' => [
                'charset' => 'UTF-8',
                'from' => [env('MAIL_USERNAME', 'supervisory@xxx.com') => '邮件预警']
            ],
        ],
        'log' => [
            'class' => 'yii\log\Dispatcher',
            'targets' => [
                [
                    'class' => 'yii\log\EmailTarget',
                    'mailer' => 'mailer',
                    'levels' => ['error', 'warning'],
                    'message' => [
                        'from' => env('MAIL_USERNAME', 'supervisory@xxx.com'),
                        //'to' => ['yuanqi.chen@xxx.com'],
                        'to' => ['server-developer@xxx.com'],
                        'subject' => 'xxx warning',
                    ],
                    'categories' => [],
                    'except' => $exceptException,
                ],

                [
                    'class' => 'yii\log\FileTarget',
                    'maxFileSize' => 1024 * 10,                            //10M
                    'enableRotation' => true,
                    'maxLogFiles' => 100,
                    'rotateByCopy' => true,
                    'logFile' => '@runtime/logs/error_' . date('Ymd') . '.log',
                    'levels' => ['error'],
                    'except' => $exceptException,
                ],

                [
                    'class' => 'yii\log\FileTarget',
                    'maxFileSize' => 1024 * 10,                            //10M
                    'enableRotation' => true,
                    'maxLogFiles' => 100,
                    'rotateByCopy' => true,
                    'logFile' => '@runtime/logs/warning_' . date('Ymd') . '.log',
                    'levels' => ['warning'],
                    'except' => $exceptException,
                ],

                [
                    'class' => 'yii\log\FileTarget',
                    'maxFileSize' => 1024 * 10,                            //10M
                    'enableRotation' => true,
                    'maxLogFiles' => 100,
                    'rotateByCopy' => true,
                    'logFile' => '@runtime/logs/' . date('Ymd') . '.log',
                    'logVars' => [],
                    'enabled' => YII_DEBUG,
                ],

                [
                    'class' => 'yii\log\FileTarget',
                    'maxFileSize' => 1024 * 10,                            //10M
                    'maxLogFiles' => 100,
                    'logFile' => '@runtime/logs/db_' . date('Ymd') . '.log',
                    'categories' => ['yii\db\*'],
                    'logVars' => [],
                    'levels' => ['info'],
                    'enabled' => !in_array(YII_ENV, ['sandbox', 'prod']),
                ],
            ], 

        ],
        'db' => $db,
        'redis' => $redis,
        'storeSessionCache' => [
            'class' => 'common\components\RedisCache',
            'redis' => 'redis',
            'keyPrefix' => 'storeSession:',
        ],
    ],
    'params' => $params,
];

if (YII_ENV_DEV && 'cli' !== php_sapi_name()) {
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
