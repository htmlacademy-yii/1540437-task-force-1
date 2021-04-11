<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "users".
 *
 * @property int $id
 * @property int|null $city_id Город
 * @property int $profile_id Профиль
 * @property string|null $gender
 * @property string|null $name Имя
 * @property string|null $password Пароль
 * @property string $email
 * @property int $is_profile_public
 * @property int $is_contact_public
 * @property string $created_at
 * @property string|null $updated_at
 * @property string|null $last_logined_at
 */
class User extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'users';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['city_id', 'profile_id', 'is_profile_public', 'is_contact_public'], 'integer'],
            [['profile_id', 'email'], 'required'],
            [['gender'], 'string'],
            [['created_at', 'updated_at', 'last_logined_at'], 'safe'],
            [['name'], 'string', 'max' => 45],
            [['password'], 'string', 'max' => 64],
            [['email'], 'string', 'max' => 245],
            [['email'], 'unique'],
            [['city_id'], 'exist', 'skipOnError' => true, 'targetClass' => City::className(), 'targetAttribute' => ['city_id' => 'id']],
            [['profile_id'], 'exist', 'skipOnError' => true, 'targetClass' => UserProfile::className(), 'targetAttribute' => ['profile_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'city_id' => Yii::t('app', 'Город'),
            'profile_id' => Yii::t('app', 'Профиль'),
            'gender' => Yii::t('app', 'Gender'),
            'name' => Yii::t('app', 'Имя'),
            'password' => Yii::t('app', 'Пароль'),
            'email' => Yii::t('app', 'Email'),
            'is_profile_public' => Yii::t('app', 'Is Profile Public'),
            'is_contact_public' => Yii::t('app', 'Is Contact Public'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
            'last_logined_at' => Yii::t('app', 'Last Logined At'),
        ];
    }
}
