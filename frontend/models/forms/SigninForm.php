<?php

namespace frontend\models\forms;

use common\models\UserIdentity as User;

class SigninForm extends \yii\base\Model
{
    public $email;
    public $password;

    /** @var User $_user */
    private $_user;

    /**
     * Правила валидации формы
     * 
     * @return array 
     */
    public function rules()
    {
        return [
            [['email', 'password'], 'required'],
            ['email', 'email'],
            ['password', 'validatePassword'],
        ];
    }

    /**
     * Подписи аттрибутов
     * 
     * @return array 
     */
    public function attributeLabels()
    {
        return [
            'email' => 'Электронная почта',
            'password' => 'Пароль'
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

    /**
     * @return null|User 
     */
    protected function getUser(): ?User
    {
        if ($this->_user === null) {
            $this->_user = User::findOne(['email' => $this->email]);
        }

        return $this->_user;
    }

    /**
     * Авторизация пользователя
     * 
     * @param int $duration Длительность хранения данных
     * @see \yii\web\User::login()
     * @return bool 
     */
    public function login(int $duration = 0)
    {
        $user = $this->getUser();

        if ($user) {
            return \Yii::$app->user->login($user, $duration);
        }

        return false;
    }
}
