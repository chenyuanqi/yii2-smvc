<?php

namespace commands\controllers;

use yii\console\Controller;
use common\helpers\TimeHelper;

class CommonController extends Controller
{
    public function stdout($message)
    {
        echo TimeHelper::date('Y-m-d H:i:s u'), '   ', $message, PHP_EOL;
    }
}
