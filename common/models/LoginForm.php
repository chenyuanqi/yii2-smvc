<?php
namespace common\models;

use Yii;
use yii\base\Model;

/**
 * Class LoginForm
 *
 * @package common\models
 *
 * @property string $mobile
 * @property string $password
 * @property $_identity
 */
class LoginForm extends Model
{
    public $mobile;

    public $password;

    private $_identity;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['mobile'], 'required'],
            [['mobile'], 'trim'],

            [['password'], 'required'],
            ['password', 'validatePassword'],
        ];
    }

    public function validatePassword($attribute)
    {
        if (!$this->hasErrors()) {
            $user = $this->getUser();
            if (!$user instanceof Users || !$user->validatePassword($this->password)) {
                $this->addError($attribute,'账号或密码错误');
            }
        }
    }

    public function login()
    {
        return $this->validate() && Yii::$app->user->login($this->_identity);
    }

    protected function getUser()
    {
        if ($this->_identity === null) {
            $this->_identity = Users::findOne(['mobile' => $this->mobile, 'status' => Users::STATUS_ACTIVE]);
        }

        return $this->_identity;
    }
}
