<?php

namespace common\base;

use yii\db\Connection;
use yii\di\Instance;

class Migration extends \yii\db\Migration
{
    /**
     * @var Connection
     */
    public $db;

    public $table;

    public function init()
    {
        $this->db = Instance::ensure($this->db, Connection::className());

        parent::init();
    }

    public function tableOptions($engine = 'InnoDB')
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql'){
            $tableOptions = "CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci ENGINE={$engine}";
        }

        return $tableOptions;
    }

    public function getCommonColumns()
    {
        return [
            'deleted_at' => $this->integer()->unsigned()->defaultValue(0)->notNull()->comment('删除时间'),
            'created_at' => $this->integer()->unsigned()->defaultValue(0)->notNull()->comment('创建时间'),
            'updated_at' => $this->integer()->unsigned()->defaultValue(0)->notNull()->comment('修改时间'),
        ];
    }

    public function tinyint($length=4){
        return $this->getDb()->getSchema()->createColumnSchemaBuilder('tinyint', $length);
    }
}
