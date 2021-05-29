<?php
namespace common\models;

/**
 * @inheritDoc
 */
class UserIdentity extends User implements \yii\web\IdentityInterface
{

    /** @inheritDoc */
    public function getId() { 
        return $this->id;
    }

    /** @inheritDoc */
    public function getAuthKey() {
        /** Заглушка */
    }

    /** @inheritDoc */
    public function validateAuthKey($authKey) {
        return $this->getAuthKey() === $authKey;
    }

    /** @inheritDoc */
    public static function findIdentity($id)
    {
        return static::findOne($id);
    }

    /** @inheritDoc */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        /** Заглушка */
    }

    /**
     * @param string $password 
     * @return bool 
     */
    public function validatePassword(string $password): bool
    {
        return \Yii::$app->getSecurity()->validatePassword($password, $this->password);
    }
    

}