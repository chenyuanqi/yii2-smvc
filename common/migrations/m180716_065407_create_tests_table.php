<?php

use common\models\Tests;
use common\base\Migration;
use yii\helpers\ArrayHelper;

/**
 * Handles the creation of table `test`.
 */
class m180716_065407_create_tests_table extends Migration
{
    public function init()
    {
        parent::init();
        $this->table = Tests::tableName();
    }

    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $columns = ArrayHelper::merge([
            'id' => $this->bigPrimaryKey(),
            'uuid' => $this->char(32)->notNull()->defaultValue('')->comment('设备ID'),
            'name' => $this->string(255)->notNull()->defaultValue('')->comment('名称'),
            'UNIQUE KEY `test_uuid` (`uuid`)',
        ], $this->getCommonColumns());

        $this->createTable($this->table, $columns, $this->tableOptions());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable($this->table);
    }
}
