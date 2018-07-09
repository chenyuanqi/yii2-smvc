<?php

require __DIR__ . '/../../bootstrap.php';

$config = includeFile(YII_ROOT . '/config/web.php');

$config['id'] = 'demo_id';
$config['name'] = 'demo_name';
$config['basePath'] = dirname(__DIR__);
$config['timeZone'] = 'PRC';
$config['charset'] = 'UTF-8';
$config['language'] = 'zh-CN';
$config['sourceLanguage'] = 'zh-CN';
$config['vendorPath'] = '@vendor';
$config['runtimePath'] = '@runtime';

$config['modules']['v1'] = ['class' => 'api\modules\v1\module'];

// 路由设定
$config['components']['apiUrlManager'] = [
        'class' => 'yii\web\UrlManager',
        'enablePrettyUrl' => true,
        'showScriptName' => false,
        'suffix' => '.json',
        'cache' => 'apiUrlManagerCache',
        'baseUrl' => '/',
        'enableStrictParsing' => true,
        'rules' => require(Yii::getAlias('@route/api.php')),
    ];
$config['components']['urlManager'] = function (){
    return Yii::$app->get('apiUrlManager');
};

return $config;

