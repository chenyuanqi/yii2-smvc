<?php

use yii\queue\redis\Queue;
use yii\queue\LogBehavior;

return [
    'bootstrap' => [
        'queue', 
    ],
    'components' => [
        'queue' => [
            'class' => Queue::class,
            'ttr' => 5 * 60, // Max time for job execution
            'attempts' => 3, // Max number of attempts
            'as log' => LogBehavior::class,
        ],
    ],
];