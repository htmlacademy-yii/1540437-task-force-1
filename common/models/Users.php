<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "users".
 *
 * @property int $id
 * @property int $city_id
 * @property int|null $profile_id
 * @property string $email
 * @property string $password_hash
 * @property string|null $token
 * @property int $is_profile_public
 * @property int $is_contact_public
 * @property string $created_at
 * @property string|null $updated_at
 * @property string|null $last_logined_at
 *
 * @property TaskChats[] $taskChats
 * @property TaskResponses[] $taskResponses
 * @property Tasks[] $customerTasks
 * @property Tasks[] $performerTasks
 * @property UserAttachments[] $userAttachments
 * @property UserCategories[] $userCategories
 * @property UserFavorites[] $userFavorites
 * @property UserNotifications[] $userNotifications
 * @property Cities $city
 * @property UserProfile $profile
 */
class Users extends \yii\db\ActiveRecord
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
            [['city_id', 'email', 'password_hash'], 'required'],
            [['city_id', 'profile_id', 'is_profile_public', 'is_contact_public'], 'integer'],
            [['created_at', 'updated_at', 'last_logined_at'], 'safe'],
            [['email'], 'string', 'max' => 245],
            [['password_hash', 'token'], 'string', 'max' => 256],
            [['email'], 'unique'],
            [['city_id'], 'exist', 'skipOnError' => true, 'targetClass' => Cities::class, 'targetAttribute' => ['city_id' => 'id']],
            [['profile_id'], 'exist', 'skipOnError' => true, 'targetClass' => UserProfile::class, 'targetAttribute' => ['profile_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'city_id' => Yii::t('app', 'City ID'),
            'profile_id' => Yii::t('app', 'Profile ID'),
            'email' => Yii::t('app', 'Email'),
            'password_hash' => Yii::t('app', 'Password Hash'),
            'token' => Yii::t('app', 'Token'),
            'is_profile_public' => Yii::t('app', 'Is Profile Public'),
            'is_contact_public' => Yii::t('app', 'Is Contact Public'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
            'last_logined_at' => Yii::t('app', 'Last Logined At'),
        ];
    }

    /**
     * Gets query for [[TaskChats]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getTaskChats()
    {
        return $this->hasMany(TaskChats::class, ['user_id' => 'id']);
    }

    /**
     * Gets query for [[TaskResponses]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getTaskResponses()
    {
        return $this->hasMany(TaskResponses::class, ['user_id' => 'id']);
    }

    /**
     * Gets query for [[Tasks]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCustomerTasks()
    {
        return $this->hasMany(Tasks::class, ['customer_user_id' => 'id'])->inverseOf('customer');
    }

    /**
     * Gets query for [[PerformerTasks]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPerformerTasks()
    {
        return $this->hasMany(Tasks::class, ['performer_user_id' => 'id'])->inverseOf('performer');
    }

    /**
     * Gets query for [[UserAttachments]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUserAttachments()
    {
        return $this->hasMany(UserAttachments::class, ['user_id' => 'id']);
    }

    /**
     * Gets query for [[UserCategories]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUserCategories()
    {
        return $this->hasMany(UserCategories::class, ['user_id' => 'id']);
    }

    /**
     * Gets query for [[UserFavorites]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUserFavorites()
    {
        return $this->hasMany(UserFavorites::class, ['favorite_user_id' => 'id']);
    }

    /**
     * Gets query for [[UserNotifications]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUserNotifications()
    {
        return $this->hasMany(UserNotifications::class, ['user_id' => 'id']);
    }

    /**
     * Gets query for [[City]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCity()
    {
        return $this->hasOne(Cities::class, ['id' => 'city_id']);
    }

    /**
     * Gets query for [[Profile]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getProfile()
    {
        return $this->hasOne(UserProfile::class, ['id' => 'profile_id']);
    }
}
