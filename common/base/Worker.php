<?php

namespace common\base;

use Yii;

class Worker extends BaseObject implements \yii\queue\JobInterface
{
    /**
     * @return Queue
     */
    public static function getQueue()
    {
        return return Yii::$app->get('queue');
    }

    public static function stdout($str)
    {
        echo TimeHelper::date('Y-m-d H:i:s u'), '   ', $str, PHP_EOL;
    }
}
