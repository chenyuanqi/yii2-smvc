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
            // 当前 rule 将会针对这里设置的 actions 起作用，如果 actions 不设置，默认就是当前控制器的所有操作
            // 'actions' => ['index'],
            // 自定义一个规则，返回true表示满足该规则，可以访问，false表示不满足规则，也就不可以访问actions里面的操作啦
            // 'matchCallback' => function ($rule, $action) {
            //     return Yii::$app->user->id == 1 ? true : false;
            // },
            // 设置 actions 的操作是允许访问还是拒绝访问
            // 'allow' => true,
            // @ 当前规则针对认证过的用户; ? 所有用户均可访问
            // 'roles' => ['@'],
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

    
    /**
     * 登录
     *
     * @return array|string|\yii\web\Response
     */
    public function actionLogin()
    {
        if (!\Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        if(Yii::$app->request->isPost) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            $timestamp = round(microtime(true), 3);
            $result = [
                'code' => \store\base\Controller::RESPONSE_CODE_HTTP_BAD_REQUEST,
                'date' => TimeHelper::date('Y-m-d H:i:s u', $timestamp),
                'timestamp' => round(microtime(true), 3),
                'message' => '账号或密码错误',
                'data' => []
            ];

            $loginForm = new LoginForm();
            if ($loginForm->load(Yii::$app->request->post(), '') && $loginForm->login()) {
                $result['code'] = \store\base\Controller::RESPONSE_CODE_HTTP_OK;
                $result['message'] = '请求成功';

                return $result;
            }

            return $result;
        }

        return $this->render('login');
    }

    /**
     * 登出
     *
     * @throws \yii\web\ForbiddenHttpException
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();
        Yii::$app->user->loginRequired();
        Yii::$app->getSession()->destroy();
        Yii::$app->response->cookies->removeAll();
    }

}

