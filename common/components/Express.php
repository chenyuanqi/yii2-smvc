<?php

namespace common\components;

final class Express
{
    public $customer = 'xxx';

    public $key = 'xxx';

    public static $expressList = [
        '中通快递' => ['code' => 'zhongtong', 'name' => '中通快递'],
        '圆通快递' => ['code' => 'yuantongkuaiyun', 'name' => '圆通快递'],
        '韵达快递' => ['code' => 'yunda', 'name' => '韵达快递'],
        '顺丰快递' => ['code' => 'shunfeng', 'name' => '顺丰快递'],
    ];

    private static $instance;

    private function __construct() 
    {}

    public static function getInstance()
    {
        if (!static::$instance instanceof static) {
            static::$instance = new static();
        }

        return static::$instance;
    }

    private function __clone()
    {}

    public function query($type, $code)
    {
        $postData = [
            'customer' => $this->customer,
            'param' => json_encode([
                'com' => self::$expressList[$type]['code'],
                'num' => $code,
            ])
        ];

        $url = 'http://poll.kuaidi100.com/poll/query.do';

        $postData["sign"] = md5($postData["param"] . $this->key . $postData["customer"]);
        $postData["sign"] = strtoupper($postData["sign"]);

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($postData));
        $result = curl_exec($ch);
        $data = str_replace("\"", '"', $result);

        return json_decode($data, true);
    }

}