<?php

require __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'bootstrap.php';

$config = includeFile(Yii::getAlias('@config') . DIRECTORY_SEPARATOR . 'web.php');

$config['id'] = 'api_id';
$config['name'] = 'api_name';
$config['timeZone'] = 'PRC';
$config['charset'] = 'UTF-8';
$config['language'] = 'zh-CN';
$config['sourceLanguage'] = 'zh-CN';
$config['vendorPath'] = '@vendor';
$config['runtimePath'] = '@runtime';

$config['basePath'] = dirname(__DIR__);
$config['modules'] = [
    'v1' => [
        'class' => 'api\modules\v1\module'
    ],
];

// 路由设定
$config['components']['urlManager'] = [
    'class' => 'yii\web\UrlManager',
    'enablePrettyUrl' => true,
    'showScriptName' => false,
    'suffix' => '',
    'cache' => 'apiUrlManagerCache',
    'baseUrl' => env('API_URL', ''),
    'enableStrictParsing' => false,
    'rules' => includeFile(YII_ROOT . DIRECTORY_SEPARATOR . 'route' . DIRECTORY_SEPARATOR . 'api.php'),
];

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
    'class' => 'yii\web\Response',
//    'on beforeSend' => function ($event) {
//        $response = $event->sender;
//        if ($response->data !== null) {
//            $response->data = [
//                'success' => true,
//                'data' => $response->data,
//            ];
//        }
//    },
];

return $config;

