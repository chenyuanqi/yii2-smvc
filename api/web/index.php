<?php

require __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'bootstrap.php';

$config = yii\helpers\ArrayHelper::merge(
	require(__DIR__ . '/../config/main.php'),
    require(__DIR__ . '/../config/queue.php')
);

try {
    (new yii\web\Application($config))->run();
} catch(yii\base\InvalidConfigException $e) {
    throw new yii\base\Exception($e, 500);
}

