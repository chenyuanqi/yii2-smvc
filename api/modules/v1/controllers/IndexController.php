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
                    'index' => ['get'],
                ]
            ]
        ];
    }


    public function actionIndex()
    {
        try{
            $data = [];
        }catch(\Exception $e){
            $data = [];
        }

        return $this->formatResult(static::RESPONSE_CODE_HTTP_OK, $data);
    }

}

