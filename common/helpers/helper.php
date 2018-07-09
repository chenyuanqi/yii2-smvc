<?php

if (!function_exists('dd')) {
    /**
     * @param mixed ...$param
     */
    function dd(...$param)
    {
        foreach ($param as $p)  {
            \yii\helpers\VarDumper::dump($p, 10, true);
        }
        exit(1);
    }
}

if (!function_exists('sql')) {
    /**
     * @param yii\db\ActiveQuery  $query
     */
    function sql(yii\db\ActiveQuery $query)
    {
        $commandQuery = clone $query;
        echo $commandQuery->createCommand()->getRawSql();
        exit(1);
    }
}

if (!function_exists('includeFile')) {
    /**
     * @param string $file 需要引入的文件
     * @param bool $skipNotExist 是否跳过不存在的文件
     * @param null $default 如果文件不存在的默认值
     * @return mixed|null
     */
    function includeFile($file, $skipNotExist = false, $default = null)
    {
        common\helpers\FileHelper::getInclude($file, $skipNotExist, $default);
    }
}

if (!function_exists('yiiUrl')) {
    /**
     * 创建url.
     *
     * @param $url string 对象的属性，或者数组的键值/索引，以'.'链接或者放入一个数组
     *
     * @return mixed mix
     **/
    function yiiUrl($url)
    {
        return Yii::$app->urlManager->createUrl($url);
    }
}

if (!function_exists('yiiParams')) {
    /**
     * 获取yii配置参数.
     *
     * @param $key string 对象的属性，或者数组的键值/索引，以'.'链接或者放入一个数组
     *
     * @return mixed mix
     **/
    function yiiParams($key)
    {
        return Yii::$app->params[$key];
    }
}

if (!function_exists('getVal')) {
    /**
     * 从对象，数组中获取获取数据.
     *
     * @param $array mixed 数组或者对象
     * @param $key array|string 对象的属性，或者数组的键值/索引，以'.'链接或者放入一个数组
     * @param $default string 如果对象或者属性中不存在该值事返回的值
     *
     * @return mixed mix
     **/
    function getVal($array, $key, $default = '')
    {
        return yii\helpers\ArrayHelper::getValue($array, $key, $default);
    }
}

if (!function_exists('app')) {
    /**
     * @param null $instance
     * @return null|object|\yii\di\Container
     * @throws \yii\base\InvalidConfigException
     * @throws \yii\di\NotInstantiableException
     */
    function app($instance = null)
    {
        if (is_null($instance)) {
            return Yii::$container;
        }

        if (Yii::$app->has($instance)) {
            return Yii::$app->get($instance);
        }

        return Yii::$container->get($instance);
    }
}

