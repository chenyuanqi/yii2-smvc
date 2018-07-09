<?php

namespace api\modules\v1\controllers;

use Yii;
use api\base\Controller;

class IndexController extends Controller
{
    public function behaviors()
    {
        return [
            'verbs' => [
                'actions' => [
                    'index' => ['GET'],
                ],
            ]
        ];
    }


    public function actionIndex()
    {
        $data = [];

        return $this->formatResult(self::RESPONSE_CODE_HTTP_OK, $data);
    }

}

