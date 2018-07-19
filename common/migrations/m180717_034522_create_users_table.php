<?php

use common\models\Users;
use common\base\Migration;
use yii\helpers\ArrayHelper;

/**
 * Handles the creation of table `users`.
 */
class m180717_034522_create_users_table extends Migration
{
    public function init()
    {
        parent::init();
        $this->table = Users::tableName();
    }

    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $columns = ArrayHelper::merge([
            'id' => $this->bigPrimaryKey()->unsigned()->comment('用户ID'),
            'username' => $this->string(255)->notNull()->comment('用户名称'),
            'password' => $this->char(60)->defaultValue('')->notNull()->comment('用户密码'),
            'salt' => $this->char(32)->defaultValue('')->notNull()->comment('密码干扰字符'),
            'email' => $this->string(100)->defaultValue('')->notNull()->comment('用户邮箱'),
            'mobile' => $this->string(20)->defaultValue('')->notNull()->comment('用户手机号码'),
            'avatar' => $this->string(255)->defaultValue('')->notNull()->comment('用户头像路径'),
            'avatar_thumb' => $this->string(255)->defaultValue('')->notNull()->comment('用户头像缩略图路径'),
            'status' => $this->tinyint()->defaultValue(0)->notNull()->comment('用户状态:1正常 0禁用'),
            'registered_at' => $this->integer()->unsigned()->defaultValue(0)->notNull()->comment('注册时间'),
            'registered_ip' => $this->bigInteger(20)->unsigned()->defaultValue(0)->notNull()->comment('注册IP'),
            'last_login_at' => $this->integer()->unsigned()->defaultValue(0)->notNull()->comment('最后登录时间'),
            'last_login_ip' => $this->bigInteger(20)->unsigned()->defaultValue(0)->notNull()->comment('最后登录IP'),

            'UNIQUE KEY `user_mobile` (`mobile`)',
            'UNIQUE KEY `user_email` (`email`)',
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
