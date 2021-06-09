<?php
namespace common\components;

/** @inheritDoc */
class WebUser extends \yii\web\User
{
    /** @inheritDoc */
    public $identityClass = \common\models\UserIdentity::class;
    /** @inheritDoc */
    public $enableAutoLogin = true;
    /** @inheritDoc */
    public $loginUrl = ['auth/signin'];
    /** @inheritDoc */
    public $identityCookie = ['name' => '_identity', 'httpOnly' => true];
}