<?php

namespace common\components;

/**
 * @property-read string|null $name Имя залогиненного пользователя
 * @property-read int|null $role Поль пользователя
 */
class WebUser extends \yii\web\User
{
    public $identityClass = \common\models\UserIdentity::class;
    public $enableAutoLogin = true;
    public $loginUrl = ['auth/signin'];
    public $returnUrl = ['task/list'];
    public $identityCookie = ['name' => '_identity', 'httpOnly' => true];

    private $_role;

    /**
     * 
     * @return null|string Username
     */
    public function getName(): ?string
    {
        $identity = $this->getIdentity();
        return $identity !== null ? $identity->name : null;
    }

    /** @return null|string Gender */
    public function getGender(): ?string
    {
        $identity = $this->getIdentity();

        return $identity !== null ? $identity->gender : null;
    }

    /**
     * Роль пользователя.
     * 
     * @see \app\bizzlogic\User::ROLE_*
     * 
     * @return int|null 
     */
    public function getRole()
    {
        $identity = $this->getIdentity();

        if ($identity === null) {
            return null;
        }

        if (!$this->_role) {
            $categoryIds = \common\models\UserCategory::find()->select('category_id')->where(['user_id' => $identity->getId()])->all();
            $this->_role = count($categoryIds) > 0 ? \app\bizzlogic\User::ROLE_PERFORMER : \app\bizzlogic\User::ROLE_CUSTOMER;
        }

        return $this->_role;
    }
}
