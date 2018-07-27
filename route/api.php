<?php

return [
    'GET index' => 'v1/index/index',

    'GET user' => 'v1/user/index',
    'POST user' => 'v1/user/add',
    'GET user/<id:\d+>' => 'v1/user/view',
    'PUT user/<id:\d+>' => 'v1/user/update',
    'DELETE user/<id:\d+>' => 'v1/user/delete',
];

