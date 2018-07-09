<?php

// define root path
defined('YII_ROOT') or define('YII_ROOT', __DIR__);

require YII_ROOT . '/vendor/autoload.php';
require YII_ROOT . '/vendor/yiisoft/yii2/Yii.php';

// program env setting
defined('YII_DEBUG') or define('YII_DEBUG', env('YII_DEBUG', true));
defined('YII_ENV') or define('YII_ENV', env('YII_ENV', 'dev'));
if (YII_DEBUG) {
    ini_set('display_errors', 'on');            // 显示错误信息
    ini_set('report_memleaks', 'on');           // 内存泄漏
    ini_set('display_startup_errors', 'on');    // 显示启动时候的错误
    ini_set('error_reporting', 2147483647);     // 显示所有错误
}

// set common alias
Yii::setAlias('commands', YII_ROOT . '/commands');
Yii::setAlias('common', YII_ROOT . '/common');
Yii::setAlias('migrations', YII_ROOT . '/migrations');
Yii::setAlias('api', YII_ROOT . '/api');
Yii::setAlias('route', YII_ROOT . '/route');
Yii::setAlias('runtime', YII_ROOT . '/runtime');
Yii::setAlias('vendor', YII_ROOT . '/vendor');

