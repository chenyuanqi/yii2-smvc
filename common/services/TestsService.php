<?php

namespace common\services;

use common\base\Service;
use common\models\Tests;
use yii\base\Excetion;

class TestsService extends Service 
{
	public static function setRecord(array $data)
    {
        $transaction = Tests::getDb()->beginTransaction();
        try{
            $test = Tests::findOne(['uuid' => $data['uuid']]);
            if (!$test instanceof Tests){
                $test = new Tests();
            }


            $test->uuid = $data['uuid'];
            $test->name = $data['name'];
            // $test->count = $test->getIsNewRecord() ? 1 : new Expression("count+'1'");
            // $test->appendLastTimes($data['lasted_at']);

            if (false === $test->validate()){
                throw new Excetion(Json::encode($test->getErrors(), JSON_UNESCAPED_UNICODE), 1);
            }

            if (false === $test->save(false)){
                throw new Excetion('保存测试数据错误', 500);
            }

            $transaction->commit();
        }catch(\Exception $e){
            $transaction->rollBack();

            throw $e;
        }
    }
}
