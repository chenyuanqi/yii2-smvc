<?php

namespace commands\controllers;

use common\models\Tests;
use yii\console\ExitCode;

class TempController extends CommonController
{
	/**
     * sync test data.
     *
     * @param int $number 批量操作数量
     * @param string $memoryLimit 设置内存限制
     * @throws \Exception
     */
    public function action20180716SyncTest($number = 2000, $memoryLimit = '512M')
    {
        ini_set('memory_limit', $memoryLimit);

        try{
            $userClassArr = [];
            $userCourseArr = [];
            $executeNumber = $number;
            $totalNumber = Tests::find()->count();
            foreach(Tests::find()->batch($number) as $datas){
                foreach($datas as $data){
                	// ...
                }
                $this->stdout("已完成记录数：{$executeNumber} / {$totalNumber}");
                $executeNumber += $number;
            }

            $this->stdout('同步数据完成！');
        }catch(\Exception $e){

            throw $e;
        }

        return ExitCode::OK;
    }
}