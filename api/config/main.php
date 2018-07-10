<?php

require __DIR__ . '/../../bootstrap.php';

$config = includeFile(YII_ROOT . '/config/web.php');

$config['id'] = 'demo_id';
$config['name'] = 'demo_name';
$config['timeZone'] = 'PRC';
$config['charset'] = 'UTF-8';
$config['language'] = 'zh-CN';
$config['sourceLanguage'] = 'zh-CN';
$config['vendorPath'] = '@vendor';
$config['runtimePath'] = '@runtime';

$config['basePath'] = dirname(__DIR__);
$config['modules'] = [
    'v1' => [
        'class' => 'api\modules\v1\module',
        'defaultRoute' => 'index',
    ],
];

// 路由设定
$config['components']['apiUrlManager'] = [
        'class' => 'yii\web\UrlManager',
        'enablePrettyUrl' => true,
        'showScriptName' => false,
        'suffix' => '',
        'cache' => 'apiUrlManagerCache',
        'baseUrl' => env('API_URL', ''),
        'enableStrictParsing' => true,
        'rules' => require(Yii::getAlias('@route/api.php')),
    ];

$config['components']['urlManager'] = function (){
    return Yii::$app->get('apiUrlManager');
};

// 请求设定
$config['components']['request'] = [
    'class' => 'api\base\Request',
    'enableCsrfValidation' => false,
    'csrfParam' => '_csrf',
    'enableCsrfCookie' => false,
    'csrfCookie' => ['httpOnly' => true],
    'enableCookieValidation' => false,
    'cookieValidationKey' => '9c63130dcfe59b2eb3a8c',
    'methodParam' => '_method',
];

// 响应设定
$config['components']['response'] = [
    'class' => 'api\base\Response',
    'format' => yii\web\Response::FORMAT_JSON,
    'formatters' => [
        yii\web\Response::FORMAT_JSON => [
            'class' => yii\web\JsonResponseFormatter::className(),
            'contentType' => 'application/x-json;charset=utf-8',
        ],
    ],
];

// 错误处理
/*
$config['components']['errorHandler'] = [
    'class' => 'api\base\ErrorHandler',
    'errorAction' => 'error',
    'useErrorAction' => true,
    'memoryReserveSize' => 0,
];
*/

return $config;

