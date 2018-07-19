<?php

namespace api\modules\v1\controllers;

use yii\rest\ActiveController;
use yii\filters\auth\QueryParamAuth;

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
        $behaviors = parent::behaviors();
        /**
         * 设置认证方式
         */
        $behaviors['authenticator'] = [
            'class' => QueryParamAuth::className(),
        ];

        return $behaviors;
    }
}