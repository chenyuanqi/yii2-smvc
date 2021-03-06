<?php

namespace common\base;

use yii\console\Controller;
use common\helpers\TimeHelper;

class Command extends Controller
{
    public function stdout($message)
    {
        echo TimeHelper::date('Y-m-d H:i:s u'), '   ', $message, PHP_EOL;
    }
}
