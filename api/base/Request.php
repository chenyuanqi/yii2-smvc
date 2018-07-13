<?php

namespace api\base;

use common\helpers\CheckHelper;
use Yii;

class Request extends \yii\web\Request
{
    public function getAuthorization()
    {
        return $this->headers->get('Authorization');
    }

    public function getSign()
    {
        return $this->headers->get('Auth-Sign');
    }

    public function getDate()
    {
        return $this->headers->get('Client-Timestamp');
    }

    /**
     * 获取用户 IP
     */
    public function getUserIP()
    {
        foreach ([
                     'HTTP_CLIENT_IP',
                     'HTTP_X_FORWARDED_FOR',
                     'HTTP_X_FORWARDED',
                     'HTTP_FORWARDED_FOR',
                     'HTTP_FORWARDED',
                     'REMOTE_ADDR'
                 ] as $name) {
            if (isset($_SERVER[$name]) && CheckHelper::isIp($_SERVER[$name])) {
                return $_SERVER[$name];
            }
        }

        return null;
    }

    /**
     * 网络状态
     *
     * @return int|string
     */
    public function getNetwork()
    {
        $cookie = $this->cookies['network'];
        $network = null === $cookie ? 0 : $cookie->value;

        return CheckHelper::isDigit($network) ? $network : 0;
    }

    /**
     * 设备
     *
     * @return string
     */
    public function getDevice()
    {
        $cookie = $this->cookies['device'];

        return null === $cookie ? '' : $cookie->value;
    }

    /**
     * uuid
     *
     * @return string
     */
    public function getUuid()
    {
        $cookie = $this->cookies['uuid'];

        return null === $cookie ? '' : $cookie->value;
    }

    /**
     * 发布渠道
     *
     * @return string
     */
    public function getChannel()
    {
        $cookie = $this->cookies['channel'];

        return null === $cookie ? '' : $cookie->value;
    }

    /**
     * 分辨率
     *
     * @return string
     */
    public function getPix()
    {
        $userAgentArray = $this->getUserAgentArray();

        return isset($userAgentArray['pix']) ? $userAgentArray['pix'] : '';
    }

    /**
     * 缩放
     *
     * @return string
     */
    public function getScale()
    {
        $userAgentArray = $this->getUserAgentArray();

        return isset($userAgentArray['scale']) ? $userAgentArray['scale'] : '';
    }

    /**
     * 设备的型号
     *
     * @return string
     */
    public function getModels()
    {
        $userAgentArray = $this->getUserAgentArray();

        return isset($userAgentArray['models']) ? $userAgentArray['models'] : '';
    }

    /**
     * 设备的厂商
     *
     * @return string
     */
    public function getVendor()
    {
        $userAgentArray = $this->getUserAgentArray();

        return isset($userAgentArray['vendor']) ? $userAgentArray['vendor'] : '';
    }

    /**
     * app的版本
     *
     * @return string
     */
    public function getAppVersion()
    {
        $userAgentArray = $this->getUserAgentArray();

        return isset($userAgentArray['appVersion']) ? $userAgentArray['appVersion'] : '';
    }

    /**
     * 系统类型
     *
     * @return int
     */
    public function getOs()
    {
        $userAgentArray = $this->getUserAgentArray();
        $os = isset($userAgentArray['os']) ? strtolower($userAgentArray['os']) : '';

        if ('ios' == $os){
            return 2;
        }elseif ('android' == $os){
            return 1;
        }else{
            return 0;
        }
    }

    /**
     * 客户端系统版本
     *
     * @return string
     */
    public function getOsVersion()
    {
        $userAgentArray = $this->getUserAgentArray();

        return isset($userAgentArray['osVersion']) ? $userAgentArray['osVersion'] : '';
    }

    protected function getUserAgentArray()
    {
        static $userAgentArray;

        if (null !== $userAgentArray){
            return $userAgentArray;
        }

        $userAgentArray = [];
        $userAgent = $this->getUserAgent();
        //$userAgent = 'CaiBeiTV/1.0.0(iOS:9.2.1;Apple:iPhone7,2;scale:2.0;pix:667*375)';
        //$userAgent = strtolower($userAgent);

        if (empty($userAgent) || 2 !== count(($userAgent = explode('(', $userAgent, 2)))){
            return $userAgentArray = [];
        }

        $userAgentArray['appVersion'] = explode('/', $userAgent[0]);
        if (2 == count($userAgentArray['appVersion'])
            && strtolower('caibeitv') == strtolower(substr($userAgentArray['appVersion'][0], 0, strlen('caibeitv')))){
            $userAgentArray['appVersion'] = $userAgentArray['appVersion'][1];
        }else{
            $userAgentArray['appVersion'] = null;
        }

        $userAgent = explode(';', rtrim($userAgent[1], ')'));

        if (isset($userAgent[0])){
            $item = explode(':', $userAgent[0]);
            if (2 == count($item)){
                $userAgentArray['os'] = $item[0];
                $userAgentArray['osVersion'] = $item[1];
            }
        }

        if (isset($userAgent[1])){
            $item = explode(':', $userAgent[1]);
            if (2 == count($item)){
                $userAgentArray['vendor'] = $item[0];
                $userAgentArray['models'] = $item[1];
            }
        }

        if (isset($userAgent[2])){
            $item = explode(':', $userAgent[2]);
            if (2 == count($item) && 'scale' == $item[0]){
                $userAgentArray['scale'] = $item[1];
            }
        }

        if (isset($userAgent[3])){
            $item = explode(':', $userAgent[3]);
            if (2 == count($item) && 'pix' == $item[0]){
                $userAgentArray['pix'] = $item[1];
            }
        }

        return $userAgentArray;
    }

    /**
     * 判断请求是否来自指定版本的客户端
     *
     * @param string $version 指定的版本号
     * @return bool
     */
    public function isAppEqVersion($version)
    {
        return $this->getAppVersion() === $version;
    }

    /**
     * 判断请求是否来自大于指定版本的客户端
     *
     * @param string $version 指定的版本号
     * @param bool $contain 是否包含该版本
     * @return bool
     */
    public function isAppLtVersion($version, $contain = false)
    {
        return version_compare($this->getAppVersion(), $version, ($contain ? '>' : '>='));
    }

    /**
     * @return \yii\console\Request|\yii\web\Request
     */
    public static function instance()
    {
        return Yii::$app->request;
    }
}

