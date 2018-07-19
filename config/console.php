<?php

$params = require __DIR__ . DIRECTORY_SEPARATOR . 'params.php';
$db = require __DIR__ . DIRECTORY_SEPARATOR . 'db.php';

$config = [
    'id' => 'basic-console',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'controllerNamespace' => 'commands\controllers',
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
    ],
    'components' => [
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
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'log' => [
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'db' => $db,
    ],
    'params' => $params,
    /*
    'controllerMap' => [
        'fixture' => [ // Fixture generation command line.
            'class' => 'yii\faker\FixtureController',
        ],
    ],
    */
];

if (YII_ENV_DEV) {
    // configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
    ];
}

return $config;
