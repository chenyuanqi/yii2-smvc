<?php

namespace api\modules\v1\controllers;

use Yii;
use api\base\Controller;
use yii\helpers\ArrayHelper;

class IndexController extends Controller
{
    public function behaviors()
    {
        return ArrayHelper::merge(parent::behaviors(), [
            'verbs' => [
                'actions' => [
                    'index' => ['GET'],
                ],
            ]
        ]);
    }

    public function actionIndex()
    {
        $data = [];

        return $this->formatResult(self::RESPONSE_CODE_HTTP_OK, $data);
    }

}

