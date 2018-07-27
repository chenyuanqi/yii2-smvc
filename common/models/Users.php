<?php

namespace common\models;

use Yii;
use yii\db\ActiveRecord;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "{{%user}}".
 *
 * @property string $username
 * @property string $password
 * @property string $salt
 * @property string $email
 * @property string $mobile
 * @property string avatar
 * @property string avatar_thumb
 * @property integer $status
 * @property integer $registered_at
 * @property integer $registered_ip
 * @property integer $last_login_at
 * @property integer $last_login_ip
 * @property integer deleted_at
 * @property integer created_at
 * @property integer updated_at
 */
class Users extends ActiveRecord
{
    const STATUS_FORBIDDEN = 0;
    const STATUS_ACTIVE  = 1;

    public static $statusLabels = [
        self::STATUS_FORBIDDEN => ['title' => '禁用'],
        self::STATUS_ACTIVE => ['title' => '正常'],
    ];


    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%users}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['username', 'password', 'salt'], 'required'],
            [['registered_at', 'registered_ip', 'last_login_at', 'last_login_ip', 'status'], 'integer'],
            [['username', 'avatar', 'avatar_thumb'], 'string', 'max' => 255],
            [['password'], 'string', 'max' => 60],
            [['email'], 'string', 'max' => 100],
            [['salt'], 'string', 'max' => 32],
            [['mobile'], 'string', 'max' => 20],
            [['email'], 'unique'],

            [['status'], 'in', 'range' => array_keys(static::$statusLabels)],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'username' => Yii::t('app', '用户名称'),
            'password' => Yii::t('app', '用户密码'),
            'salt' => Yii::t('app', '密码干扰字符'),
            'email' => Yii::t('app', '用户邮箱'),
            'mobile' => Yii::t('app', '用户手机号码'),
            'avatar' => Yii::t('app', '用户头像路径'),
            'avatar_thumb' => Yii::t('app', '用户头像缩略图路径'),
            'status' => Yii::t('app', '用户状态'),
            'registered_at' => Yii::t('app', '注册时间'),
            'registered_ip' => Yii::t('app', '注册IP'),
            'last_login_at' => Yii::t('app', '最后登录时间'),
            'last_login_ip' => Yii::t('app', '最后登录IP'),
            'deleted_at' => Yii::t('app', '删除时间'),
            'created_at' => Yii::t('app', '创建时间'),
            'updated_at' => Yii::t('app', '修改时间'),
        ];
    }

    /**
     * @inheritdoc
     */
    public function fields()
    {
        return parent::fields();
    }

    /**
     * @return array
     */
    public function behaviors()
    {
        return [
            [
                'class' => TimestampBehavior::className(),
                'createdAtAttribute' => 'created_at, registered_at, last_login_at',
                'updatedAtAttribute' => 'updated_at',
                'value' => time(),
            ],
        ];
    }
}