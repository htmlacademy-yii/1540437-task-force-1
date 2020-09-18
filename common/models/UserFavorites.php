<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "user_favorites".
 *
 * @property int $id
 * @property int $user_id
 * @property int $favorite_user_id
 *
 * @property Users $favoriteUser
 * @property Users $user
 */
class UserFavorites extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'user_favorites';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id', 'favorite_user_id'], 'required'],
            [['user_id', 'favorite_user_id'], 'integer'],
            [['favorite_user_id'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['favorite_user_id' => 'id']],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'user_id' => Yii::t('app', 'User ID'),
            'favorite_user_id' => Yii::t('app', 'Favorite User ID'),
        ];
    }

    /**
     * Gets query for [[FavoriteUser]].
     *
     * @return \yii\db\ActiveQuery|\common\models\aq\UsersQuery
     */
    public function getFavoriteUser()
    {
        return $this->hasOne(Users::className(), ['id' => 'favorite_user_id']);
    }

    /**
     * Gets query for [[User]].
     *
     * @return \yii\db\ActiveQuery|\common\models\aq\UsersQuery
     */
    public function getUser()
    {
        return $this->hasOne(Users::className(), ['id' => 'user_id']);
    }

    /**
     * {@inheritdoc}
     * @return \common\models\aq\UserFavoritesQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \common\models\aq\UserFavoritesQuery(get_called_class());
    }
}
