<?php

namespace frontend\models\forms;

use common\models\UserIdentity as User;

class SigninForm extends \yii\base\Model
{
    public $email;
    public $password;

    /** @var User $_user */
    private $_user;

    /** @inheritDoc */
    public function rules()
    {
        return [
            [['email', 'password'], 'required'],
            ['email', 'email'],
            ['password', 'validatePassword'],
        ];
    }

    /**
     * 
     * @param string $attribute Attribte name
     * @param mixed $params 
     * @return void 
     */
    public function validatePassword($attribute, $params)
    {
        if (!$this->hasErrors()) {
            $user = $this->getUser();
            if (!$user || !$user->validatePassword($this->password)) {
                $this->addError($attribute, 'Неправильный email или пароль');
            }
        }
    }

    protected function getUser(): ?User
    {
        if ($this->_user === null) {
            $this->_user = User::findOne(['email' => $this->email]);
        }

        return $this->_user;
    }

    public function login()
    {
        $user = $this->getUser();

        if ($user) {
            \Yii::$app->user->login($user);
            return true;
        }

        return false;
    }
}
