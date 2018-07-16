<?php

namespace common\traits;

use Yii;

trait InstantiateTrait
{
    public static function instantiate(array $config = [], $refresh = false)
    {
        static $instance;

        if (null === $instance || $refresh) {
            $config['class'] = get_called_class();
            $instance = Yii::createObject($config);
        }

        return $instance;
    }
}
