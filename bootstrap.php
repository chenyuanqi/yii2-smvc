<?php

// env.php 当前开发者环境配置
/*
ini_set('display_errors', 'on');            // 显示错误信息
ini_set('report_memleaks', 'on');           // 内存泄漏
ini_set('display_startup_errors', 'on');    // 显示启动时候的错误
ini_set('error_reporting', 2147483647);     // 显示所有错误
define('YII_ENV', 'dev');                   // 当前环境 network_dev
define('YII_DEBUG', true);                  // 是否开启debug模式
define('DEVELOPER', 'vikey.chen');          // 当前开发者
*/
if (is_file(__DIR__ . '/env.php')) {
    call_user_func(function () {
        require __DIR__ . '/env.php';
    });
}

// comment out the following two lines when deployed to production
defined('YII_DEBUG') or define('YII_DEBUG', true);
defined('YII_ENV') or define('YII_ENV', 'dev');

// define root path
defined('YII_ROOT') or define('YII_ROOT', __DIR__);

require YII_ROOT . '/vendor/autoload.php';
require YII_ROOT . '/vendor/yiisoft/yii2/Yii.php';

// require helper
require YII_ROOT . '/common/helpers/helper.php';

// set common alias
Yii::setAlias('commands', YII_ROOT . '/commands');
Yii::setAlias('common', YII_ROOT . '/common');
Yii::setAlias('migrations', YII_ROOT . '/migrations');
Yii::setAlias('api', YII_ROOT . '/api');
Yii::setAlias('route', YII_ROOT . '/route');
Yii::setAlias('runtime', YII_ROOT . '/runtime');
Yii::setAlias('vendor', YII_ROOT . '/vendor');

