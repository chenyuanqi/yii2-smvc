<?php

namespace api\base;

use Yii;
use common\helpers\TimeHelper;

class Controller extends \yii\web\Controller
{
    protected $saveRequestResponse = true;

    const RESPONSE_CODE_HTTP_SERVICE_UNAVAILABLE = 503;
    const RESPONSE_CODE_HTTP_SERVER_ERROR        = 500;
    const RESPONSE_CODE_HTTP_NOT_FOUND           = 404;
    const RESPONSE_CODE_HTTP_FORBIDDEN           = 403;
    const RESPONSE_CODE_HTTP_UNAUTHORIZED        = 401;
    const RESPONSE_CODE_HTTP_BAD_REQUEST         = 400;
    const RESPONSE_CODE_HTTP_OK                  = 200;

    public static $responseCodeLabels = [
        self::RESPONSE_CODE_HTTP_SERVER_ERROR => ['title' => '服务器繁忙'],
        self::RESPONSE_CODE_HTTP_NOT_FOUND => ['title' => '访问的页面出错啦'],
        self::RESPONSE_CODE_HTTP_BAD_REQUEST => ['title' => '请求参数错误'],
        self::RESPONSE_CODE_HTTP_SERVICE_UNAVAILABLE => ['title' => '服务器繁忙'],
        self::RESPONSE_CODE_HTTP_FORBIDDEN => ['title' => '没有权限访问'],
        self::RESPONSE_CODE_HTTP_UNAUTHORIZED => ['title' => '请先登录再重试哦'],
        self::RESPONSE_CODE_HTTP_OK => ['title' => '请求成功'],
    ];

    public function behaviors()
    {
        return [];
    }

    /**
     * @param $action
     * @return bool
     */
    public function beforeAction($action)
    {
        return true;
    }

    public function afterAction($action, $result)
    {
        return parent::afterAction($action, $result);
    }

    /**
     * @param $code
     * @param string $default
     * @return string
     */
    protected function getMessage($code, $default = 'ok')
    {
        if (isset(static::$responseCodeLabels[$code])){
            return static::$responseCodeLabels[$code]['title'];
        }else{
            return $default;
        }
    }

    /**
     * @param $code
     * @param array $data
     * @param string $message
     * @return array
     */
    public function formatResult($code, $data = [], $message = '')
    {
        $timestamp = round(microtime(true), 3);
        $result = [
            'code' => $code,
            'date' => TimeHelper::date('Y-m-d H:i:s u', $timestamp),
            'timestamp' => $timestamp,
        ];

        $result['message'] = $message ?: $this->getMessage($code);
        $result['data'] = $data ?: [];

        return $result;
    }
}



