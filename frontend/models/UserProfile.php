<?php

namespace frontend\models;

use frontend\models\query\UserQuery;
use Yii;

/**
 * {@inheritDoc}
 * 
 * @property User $user
 */
class UserProfile extends \common\models\UserProfile
{
    /**
     * Gets query for [[Users]].
     *
     * @return UserQuery
     */
    public function getUser(): UserQuery
    {
        return $this->hasOne(User::class, ['profile_id' => 'id']);
    }
}
