<?php

if (!function_exists('dd')){
    /**
     * @param mixed ...$param
     */
    function dd(...$param)
    {
        foreach($param as $p){
            \yii\helpers\VarDumper::dump($p, 10, true);
        }
        exit(1);
    }
}

if (!function_exists('sql')){
    /**
     * @param yii\db\ActiveQuery $query
     */
    function sql(yii\db\ActiveQuery $query)
    {
        $commandQuery = clone $query;
        echo $commandQuery->createCommand()->getRawSql();
        exit(1);
    }
}

if (!function_exists('debug')){
   /**
     * 调用这个方法之前干了什么
     *
     * @param bool $reverse
     * @return array
     */
    function debug($reverse = false)
    {
        $debug = debug_backtrace();
        $data = [];
        foreach($debug as $e)
        {
            $function = isset($e['function']) ? $e['function'] : 'null function';
            $class = isset($e['class']) ? $e['class'] : 'null class';
            $file = isset($e['file']) ? $e['file'] : 'null file';
            $line = isset($e['line']) ? $e['line'] : 'null';
            $data[] = $file . '(' . $line . '),' . $class . '::' . $function . '()';
        }
        return $reverse == true ? array_reverse($data) : $data;
    }
}

if (!function_exists('env')){
    /**
     * 获取配置，支持 boolean, empty and null.
     *
     * @param  string $key
     * @param  mixed $default
     * @return mixed
     */
    function env($key, $default = null)
    {
        $value = getenv($key);
        if ($value === false){
            return $default;
        }
        switch(strtolower($value)){
            case 'true':
            case '(true)':
                return true;
            case 'false':
            case '(false)':
                return false;
            case 'empty':
            case '(empty)':
                return '';
            case 'null':
            case '(null)':
                return;
        }

        return $value;
    }
}

if (!function_exists('includeFile')){
    /**
     * @param string $file 需要引入的文件
     * @param bool $skipNotExist 是否跳过不存在的文件
     * @param null $default 如果文件不存在的默认值
     * @return mixed|null
     */
    function includeFile($file, $skipNotExist = false, $default = null)
    {
        return common\helpers\FileHelper::getInclude($file, $skipNotExist, $default);
    }
}

if (!function_exists('exportExcel')){
    /**
     * 导出 Excel
     *
     * @param array $exportData
     * @param array $title
     * @param string $sheetName
     * @return string
     */
    function exportExcel($exportData = [], $title = [], $sheetName = 'export')
    {
        set_time_limit(120);
        ini_set('memory_limit', '512M');

        $objPHPExcel = new \PHPExcel();
        $sheet = $objPHPExcel->setActiveSheetIndex(0);

        $head = [];
        for($i = 'A'; $i != 'GZ'; ++$i){
            $head[] = $i;
        }

        if (!empty($title)){
            // 设置行头
            foreach($title as $key => $value){
                $sheet->setCellValueExplicit($head[$key] . '1', $value);
            }

            $item = 2;
        }else{
            $item = 1;
        }

        foreach($exportData as $key => $value){
            $data = array_values($value);
            foreach($data as $k => $v){
                if (!empty($title) && $k >= count($title)){
                    continue;
                }
                $sheet->setCellValueExplicit($head[$k] . $item, $v);
            }
            $item++;
        }

        $sheet->setTitle($sheetName);
        $objWriter = \PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');

        ob_start();
        $objWriter->save('php://output');
        $content = ob_get_contents();
        ob_end_clean();

        return $content;
    }
}

if (!function_exists('yiiUrl')){
    /**
     * 创建url.
     *
     * @param $url string 对象的属性，或者数组的键值/索引，以'.'链接或者放入一个数组
     *
     * @return mixed mix
     **/
    function yiiUrl($url)
    {
        return Yii::$app->urlManager->createUrl($url);
    }
}

if (!function_exists('yiiParams')){
    /**
     * 获取yii配置参数.
     *
     * @param $key string 对象的属性，或者数组的键值/索引，以'.'链接或者放入一个数组
     *
     * @return mixed mix
     **/
    function yiiParams($key)
    {
        return Yii::$app->params[$key];
    }
}

if (!function_exists('getVal')){
    /**
     * 从对象，数组中获取获取数据.
     *
     * @param $array mixed 数组或者对象
     * @param $key array|string 对象的属性，或者数组的键值/索引，以'.'链接或者放入一个数组
     * @param $default string 如果对象或者属性中不存在该值事返回的值
     *
     * @return mixed mix
     **/
    function getVal($array, $key, $default = '')
    {
        return yii\helpers\ArrayHelper::getValue($array, $key, $default);
    }
}

if (!function_exists('app')){
    /**
     * @param null $instance
     * @return null|object|\yii\di\Container
     * @throws \yii\base\InvalidConfigException
     * @throws \yii\di\NotInstantiableException
     */
    function app($instance = null)
    {
        if (is_null($instance)){
            return Yii::$container;
        }

        if (Yii::$app->has($instance)){
            return Yii::$app->get($instance);
        }

        return Yii::$container->get($instance);
    }
}
