<?php

namespace common\helpers;

use yii\web\NotFoundHttpException;
use yii\web\UnprocessableEntityHttpException;

final class EncryptionHelper
{
    /**
     * rsa 加密
     * openssl genrsa -out rsa_private_key.pem 1024 // 生成原始 RSA 私钥文件 rsa_private_key.pem
     * openssl pkcs8 -topk8 -inform PEM -in rsa_private_key.pem -outform PEM -nocrypt -out private_key.pem // 将原始 RSA 私钥转换为 pkcs8 格式
     * openssl rsa -in rsa_private_key.pem -pubout -out rsa_public_key.pem // 生成 RSA 公钥 rsa_public_key.pem
     *
     * @param string $data 数据
     * @param string $rsaPrivateKey 私钥 PEM 文件的绝对路径
     * @return string
     */
    public static function RsaEnCode($data, $rsaPrivateKey)
    {
        /* 获取私钥 PEM 文件内容 */
        $priKey = file_get_contents($rsaPrivateKey);
        /* 从 PEM 文件中提取私钥 */
        $res = openssl_get_privatekey($priKey);
        /* 对数据进行签名 */
        //openssl_sign($data, $sign, $res);
        openssl_private_encrypt($data, $sign, $res);
        /* 释放资源 */
        openssl_free_key($res);
        /* 对签名进行 Base64 编码，变为可读的字符串 */
        $sign = base64_encode($sign);
        return $sign;
    }

    /**
     * rsa 解密
     *
     * @param string $data 加密后的数据
     * @param string $rsaPublicKey 公钥 PEM 文件的绝对路径
     * @return mixed
     */
    public static function RsaDeCode($data, $rsaPublicKey)
    {
        /* 获取公钥 PEM 文件内容 */
        $pubKey = file_get_contents($rsaPublicKey);
        /* 从 PEM 文件中提取公钥 */
        $res = openssl_get_publickey($pubKey);
        /* 对数据进行解密 */
        openssl_public_decrypt(base64_decode($data), $decrypted, $res);
        /* 释放资源 */
        openssl_free_key($res);
        return $decrypted;
    }

    /**
     * 创建参数 (包括签名的处理)
     *
     * $paramArr = [
     *     'time' => time(),
     *     'nonceStr' => \common\helpers\StringHelper::random(8),
     *     'appId' => 'doormen',
     *  ]
     * @param array $paramArr 变量参数
     * @param string $secret 秘钥 (appSecret)
     * @return string
     */
    public static function createUrlParam(array $paramArr = [], $secret, $signName = 'sign')
    {
        $paraStr = "";
        ksort($paramArr);
        foreach ($paramArr as $key => $val)
        {
            if ($key != '' && $val != '')
            {
                $paraStr .= $key . '=' . urlencode($val) . '&';
            }
        }
        // 去掉最后一个 &
        $paraStr = substr($paraStr, 0, strlen($paraStr) - 1);
        $signStr = $paraStr . $secret;// 排好序的参数加上 secret, 进行 md5
        $sign = strtolower(md5($signStr));
        $paraStr .= '&';
        $paraStr .= $signName . '=' . $sign;// 将 md5 后的值作为参数, 便于服务器的效验
         return $paraStr;
    }

    /**
     * 解密 url
     *
     * @param array $paramArr
     * @param $secret
     * @param string $signName
     * @throws UnprocessableEntityHttpException
     */
    public static function decodeUrlParam(array $paramArr = [], $secret, $signName = 'sign')
    {
        // 验证必填参数 time/nonceStr/appId/signature
        if (!isset($paramArr['time']))
        {
            throw new UnprocessableEntityHttpException('缺少参数 time');
        }
        if (!isset($paramArr['sign']))
        {
            throw new UnprocessableEntityHttpException('缺少参数 sign');
        }
        if (!isset($paramArr['appId']))
        {
            throw new UnprocessableEntityHttpException('缺少参数 appId');
        }
        if (time() - 60 > $paramArr['time'])
        {
            throw new UnprocessableEntityHttpException('时间已过期');
        }
        $sign = $paramArr[$signName];
        unset($paramArr[$signName]);
        ksort($paramArr);
        $signStr = '';
        foreach ($paramArr as $key => $val)
        {
            $signStr .= $key . '=' . urlencode($val) . '&';
        }
        // 去掉最后一个 &
        $signStr = substr($signStr, 0, strlen($signStr) - 1);
        // 排好序的参数加上 secret, 进行 md5
        $signStr .= $secret;
        if (strtolower(md5($signStr)) !== $sign)
        {
            throw new UnprocessableEntityHttpException('签名错误');
        }
        return true;
    }
}
