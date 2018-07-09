<?php

namespace api\base;

class Response extends \yii\web\Response
{
    public function sendHeaders()
    {
        $this->headers->add("Access-Control-Allow-Origin", "*");
        $this->headers->add("Access-Control-Allow-Methods", "GET, POST, OPTIONS");
        $this->headers->add('Access-Control-Allow-Credentials', 'true');
        $this->headers->add("Access-Control-Allow-Headers", "Content-Type, Content-Length, User-Agent, Accept-Language, Accept-Encoding, Authorization, Auth-Sign, Client-date, Client-Timestamp, Accept, X-Requested-With");

        return parent::sendHeaders();
    }
}

