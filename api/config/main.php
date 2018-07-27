<?php

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
$config['modules']['v1'] = ['class' => 'api\modules\v1\module', 'defaultRoute' => 'index'];

// 路由设定
$config['components']['urlManager'] = [
    'class' => 'yii\web\UrlManager',
    'enablePrettyUrl' => true,
    'showScriptName' => false,
    'suffix' => '',
    'cache' => 'apiUrlManagerCache',
    'baseUrl' => env('API_URL', ''),
    'enableStrictParsing' => false,
    'rules' => includeFile(Yii::getAlias('@route') . DIRECTORY_SEPARATOR . 'api.php'),
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
    'parsers' => [
        'application/json' => 'yii\web\JsonParser',
    ],
];

// 响应设定
$config['components']['response'] = [
    'class' => 'yii\web\Response',
    'format' => api\base\Response::FORMAT_JSON,
    'on beforeSend' => function ($event) {
        $response = $event->sender;
        if ($response->data === null) {
            $response->data = [
                'error' => isset($response->data->code) ? $response->data->code : 500,
                'message' => isset($response->data->message) ? $response->data->message : '服务器异常~',
            ];
        }
    },
];

// 用户设定
$config['components']['user'] = [
    'class' => 'yii\web\User',
    'identityClass' => 'common\models\Users',
    'enableAutoLogin' => true,
    'enableSession' => false,
    'loginUrl' => null,
];

return $config;

