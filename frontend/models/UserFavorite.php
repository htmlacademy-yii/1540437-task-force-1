<?php

namespace frontend\models;

use Yii;

/**
 *
 * @property User $user
 */
class UserFavorite extends \yii\db\ActiveRecord
{
    /**
     * Gets query for [[FavoriteUser]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::class, ['id' => 'favorite_user_id']);
    }
}
