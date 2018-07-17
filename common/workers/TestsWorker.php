<?php

namespace common\workers;

use common\base\Worker;

class TestsWorker extends Worker
{
	/**
     * @param $tasks
     * @throws \Exception
     */
    public static function execute($tasks)
    {
    	try{
    		foreach($tasks as $task){
    			$logs = $task['message'];
    			
    			foreach($logs as $log){
    				// ...
    			}

    			static::stdout("someone do something.");
    		}
    	}catch(\Exception $e){
    		$error = 'data: ' . json_encode($task, JSON_UNESCAPED_UNICODE) . PHP_EOL
    		           . 'code: '. $e->getCode() . PHP_EOL
                       . 'message: '. $e->getMessage() . PHP_EOL
                       . 'trace: ' . $e->getTraceAsString();
            static::stdout($error);
    	}
    }

	public static function push($logs, $delaySeconds = 0)
    {
        return parent::push($logs, $delaySeconds);
    }
}
