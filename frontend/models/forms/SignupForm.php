<?php

namespace frontend\models\forms;

use Yii;
use yii\base\Model;
use frontend\models\User;
use frontend\models\UserProfile;

/**
 * Signup form
 */
class SignupForm extends Model
{
    public $username;
    public $email;
    public $password;
    public $city;


    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            ['username', 'trim'],
            ['username', 'required'],
            ['username', 'string', 'min' => 2, 'max' => 255],

            ['email', 'trim'],
            ['email', 'required'],
            ['email', 'email'],
            ['email', 'string', 'max' => 255],
            ['email', 'unique', 'targetClass' => User::class, 'message' => 'This email address has already been taken.'],

            ['password', 'required'],
            ['password', 'string', 'min' => Yii::$app->params['user.passwordMinLength']],
        ];
    }

    /**
     * Signs user up.
     *
     * @return bool whether the creating new account was successful and email was sent
     */
    public function signup()
    {
        if (!$this->validate()) {
            return null;
        }

        $user = new User();
        $user->name = $this->username;
        $user->email = $this->email;
        $user->city_id = $this->city;
        $user->setPassword($this->password);

        $userProfile = new UserProfile();

        $transaction = Yii::$app->db->beginTransaction();

        try {
            $userProfile->save();
            $user->link('profile', $userProfile);
            $transaction->commit();
            return true;
        } catch (\Exception $e) {
            $transaction->rollBack();
            return false;
        }
    }

    public static function cityMap() :array
    {
        return [
            'Moscow' => 'Москва',
            'SPB' => 'Санкт-Петербург',
            'Krasnodar' => 'Краснодар',
            'Irkutsk' => 'Иркутск',
            'Vladivostok' => 'Владивосток'
        ];
    }

    /** @inheritDoc */
    public function attributeLabels(): array
    {
        return  [
            'username' => 'Ваше имя',
            'email' => 'Электронная почта',
            'city' => 'Город проживания',
            'password' => 'Пароль'
        ];
    }

    /** @inheritDoc */
    public function attributeHints(): array
    {
        return [
            'username' => 'Введите ваше имя и фамилию',
            'email' => 'Введите валидный адрес электронной почты',
            'city' => 'Укажите город, чтобы находить подходящие задачи',
            
        ];
    }
}
