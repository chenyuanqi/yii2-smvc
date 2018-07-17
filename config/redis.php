<?php

return [
    'class' => 'yii\redis\Connection',
    'port' => env('REDIS_PORT', 6379),
    'database' => env('REDIS_DATABASE', 1),
    'hostname' => env('REDIS_HOST', 'localhost'),
    'password' => env('REDIS_PASSWORD', null),
    'retries' => env('REDIS_RETRIES', 1),
];
