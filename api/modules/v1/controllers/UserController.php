<?php

namespace api\modules\v1\controllers;

use Yii;
use yii\rest\ActiveController;
use yii\filters\auth\QueryParamAuth;
use yii\helpers\ArrayHelper;

/**
 * 这里注意是继承 yii\rest\ActiveController 因为源码中已经帮我们实现了 index/update 等方法
 * 以及其访问规则 verbs() 等，
 * 其他可参考：http://www.yiichina.com/doc/guide/2.0/rest-controllers
 *
 * @package api\modules\v1\controllers
 */
class UserController extends ActiveController
{
    public $modelClass = 'common\models\Users';

    public function behaviors()
    {
        return ArrayHelper::merge(parent::behaviors(), [
            'verbs' => [
                'actions' => [
                    'index' => ['GET'],
                    'add' => ['POST'],
                    'view' => ['GET'],
                    'update' => ['PUT'],
                    'delete' => ['DELETE'],
                ],
            ],
            // 设置认证方式
            // 'authenticator' => [
            //     'class' => QueryParamAuth::className(),
            // ],
        ]);
    }

    public function actionIndex()
    {
        $data = Users::find()->all();

        return $this->formatResult(self::RESPONSE_CODE_HTTP_OK, $data);
    }

    public function actionAdd()
    {}

    public function actionView($id)
    {
        return Users::findOne($id);
    }

    public function actionUpdate($id)
    {}

    public function actionDelete($id)
    {}
}