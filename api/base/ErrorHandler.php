<?php

namespace api\base;

use yii;

class ErrorHandler extends \yii\web\ErrorHandler
{
    public $useErrorAction = false;

    protected function renderException($exception)
    {
        if ($this->useErrorAction){
            $result = Yii::$app->runAction($this->errorAction);

            /**
             * 任何以\yii\base\Response为基类的实例都当成相应组件的返回
             */
            if ($result instanceof \yii\base\Response){
                $response = $result;
            }else{
                if (Yii::$app->has('response')){
                    $response = Yii::$app->getResponse();
                    $response->isSent = false;
                    $response->stream = $response->data = $response->content = null;
                }else{
                    $response = new Response();
                }
                $response->data = $result;
            }
            $response->send();
        }else{
            return parent::renderException($exception);
        }
    }
}

