<?php

return [
    'class' => 'yii\db\Connection',
    'dsn' => env('DB_DSN', 'mysql:host=localhost;dbname=yii2-smvc'),
    'username' => env('DB_USERNAME', 'root'),
    'password' => env('DB_PASSWORD', ''),
    'charset' => env('DB_CHARSET', 'utf8'),
    'tablePrefix' => env('DB_TABLE_PREFIX', ''),

    // Schema cache options (for production environment)
    //'enableSchemaCache' => true,
    //'schemaCacheDuration' => 60,
    //'schemaCache' => 'cache',
];
