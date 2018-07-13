<?php

$config = require __DIR__ . '/../config/main.php';

try {
    (new yii\web\Application($config))->run();
} catch(yii\base\InvalidConfigException $e) {
    dd($e);
}

