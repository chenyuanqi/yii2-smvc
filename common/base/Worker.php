<?php

namespace common\base;

use Yii;
use yii\base\BaseObject;
use common\helpers\TimeHelper;

class Worker extends BaseObject implements \yii\queue\JobInterface
{
    /**
     * @return Queue
     */
    public static function getQueue()
    {
        return return Yii::$app->get('queue');
    }

    /**
     * push message to the queue.
     *
     * @param array $message
     * @param int $delaySeconds
     */
    public static function push(array $message, $delaySeconds = 0)
    {
        return static::getQueue()->delay($delaySeconds)->push(new static($message));
    }

    /**
     * standard output.
     */
    public static function stdout($message)
    {
        echo TimeHelper::date('Y-m-d H:i:s u'), '   ', $message, PHP_EOL;
    }
}
