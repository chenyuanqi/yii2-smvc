<?php

namespace commands\controllers;

use common\models\Tests;

class TempController extends \yii\console\Controller
{
	/**
     * sync test data.
     *
     * @throws \Exception
     */
    public function action20180716SyncTest()
    {
        ini_set('memory_limit', '512M');

        try{
            $userClassArr = [];
            $userCourseArr = [];
            $batchNumber = $executeNumber = 2000;
            $totalNumber = Tests::find()->count();
            foreach(Tests::find()->batch($batchNumber) as $datas){
                foreach($datas as $data){
                	// ...
                }
                echo "已完成记录数：{$executeNumber} / {$totalNumber}" . PHP_EOL;
                $executeNumber += $batchNumber;
            }

            echo '同步数据完成！' . PHP_EOL;
        }catch(\Exception $e){

            throw $e;
        }
    }
}