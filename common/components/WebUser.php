<?php

namespace common\components;

/**
 * @property-read string|null $name Имя залогиненного пользователя
 */
class WebUser extends \yii\web\User
{
    public $identityClass = \common\models\UserIdentity::class;
    public $enableAutoLogin = true;
    public $loginUrl = ['auth/signin'];
    public $identityCookie = ['name' => '_identity', 'httpOnly' => true];

    /**
     * 
     * @return null|string Username
     */
    public function getName(): ?string
    {
        $identity = $this->getIdentity();
        return $identity !== null ? $identity->name : null;
    }
}
