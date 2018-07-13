<?php

// define root path
defined('YII_ROOT') or define('YII_ROOT', __DIR__);

// loading vendor
require YII_ROOT .  DIRECTORY_SEPARATOR . 'vendor' . DIRECTORY_SEPARATOR . 'autoload.php';

// reset env setting
defined('YII_DEBUG') or define('YII_DEBUG', env('YII_DEBUG', true));
defined('YII_ENV') or define('YII_ENV', env('YII_ENV', 'dev'));
// show all debug info when YII_DEBUG is true
if (YII_DEBUG) {
    ini_set('display_errors', 'on');            // 显示错误信息
    ini_set('report_memleaks', 'on');           // 内存泄漏
    ini_set('display_startup_errors', 'on');    // 显示启动时候的错误
    ini_set('error_reporting', 2147483647);     // 显示所有错误
}

// loading Yii bootstrap file
require YII_ROOT . DIRECTORY_SEPARATOR . 'vendor' . DIRECTORY_SEPARATOR. 'yiisoft' . DIRECTORY_SEPARATOR . 'yii2' . DIRECTORY_SEPARATOR . 'Yii.php';

// set common alias
Yii::setAlias('commands', YII_ROOT . DIRECTORY_SEPARATOR . 'commands');
Yii::setAlias('common', YII_ROOT . DIRECTORY_SEPARATOR . 'common');
Yii::setAlias('migrations', YII_ROOT . DIRECTORY_SEPARATOR . 'migrations');
Yii::setAlias('config', YII_ROOT . DIRECTORY_SEPARATOR . 'config');
Yii::setAlias('api', YII_ROOT . DIRECTORY_SEPARATOR . 'api');
Yii::setAlias('route', YII_ROOT . DIRECTORY_SEPARATOR . 'route');
Yii::setAlias('runtime', YII_ROOT . DIRECTORY_SEPARATOR . 'runtime');
Yii::setAlias('vendor', YII_ROOT . DIRECTORY_SEPARATOR . 'vendor');

