<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "users".
 *
 * @property int $id
 * @property int $city_id
 * @property string|null $about
 * @property int $role
 * @property string $first_name
 * @property string|null $last_name
 * @property string $email
 * @property string|null $birth_date
 * @property string $password_hash
 * @property string|null $token
 * @property string|null $phone
 * @property string|null $skype
 * @property string|null $telegramm
 * @property int $failed_task_count
 * @property int $is_profile_public
 * @property int $is_contact_public
 * @property string $created_at
 * @property string|null $updated_at
 * @property string $last_logined_at
 *
 * @property TaskMessages[] $taskMessages
 * @property TaskResponses[] $taskResponses
 * @property Tasks[] $tasks
 * @property UserAttachments[] $userAttachments
 * @property UserCategories[] $userCategories
 * @property UserFavorites[] $userFavorites
 * @property UserNotifications[] $userNotifications
 * @property Cities $city
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
            [['city_id', 'role', 'first_name', 'email', 'password_hash'], 'required'],
            [['city_id', 'role', 'failed_task_count', 'is_profile_public', 'is_contact_public'], 'integer'],
            [['about'], 'string'],
            [['birth_date', 'created_at', 'updated_at', 'last_logined_at'], 'safe'],
            [['first_name', 'last_name', 'email'], 'string', 'max' => 245],
            [['password_hash', 'token'], 'string', 'max' => 256],
            [['phone', 'skype', 'telegramm'], 'string', 'max' => 128],
            [['email'], 'unique'],
            [['city_id'], 'exist', 'skipOnError' => true, 'targetClass' => Cities::class, 'targetAttribute' => ['city_id' => 'id']],
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
            'about' => Yii::t('app', 'About'),
            'role' => Yii::t('app', 'Role'),
            'first_name' => Yii::t('app', 'First Name'),
            'last_name' => Yii::t('app', 'Last Name'),
            'email' => Yii::t('app', 'Email'),
            'birth_date' => Yii::t('app', 'Birth Date'),
            'password_hash' => Yii::t('app', 'Password Hash'),
            'token' => Yii::t('app', 'Token'),
            'phone' => Yii::t('app', 'Phone'),
            'skype' => Yii::t('app', 'Skype'),
            'telegramm' => Yii::t('app', 'Telegramm'),
            'failed_task_count' => Yii::t('app', 'Failed Task Count'),
            'is_profile_public' => Yii::t('app', 'Is Profile Public'),
            'is_contact_public' => Yii::t('app', 'Is Contact Public'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
            'last_logined_at' => Yii::t('app', 'Last Logined At'),
        ];
    }

    /**
     * Gets query for [[TaskMessages]].
     *
     * @return \yii\db\ActiveQuery|\common\models\aq\TaskMessagesQuery
     */
    public function getTaskMessages()
    {
        return $this->hasMany(TaskMessages::class, ['user_id' => 'id']);
    }

    /**
     * Gets query for [[TaskResponses]].
     *
     * @return \yii\db\ActiveQuery|\common\models\aq\TaskResponsesQuery
     */
    public function getTaskResponses()
    {
        return $this->hasMany(TaskResponses::class, ['user_id' => 'id']);
    }

    /**
     * Gets query for [[Tasks]].
     *
     * @return \yii\db\ActiveQuery|\common\models\aq\TasksQuery
     */
    public function getPerformerTasks()
    {
        return $this->hasMany(Tasks::class, ['performer_user_id' => 'id']);
    }

    /**
     * Gets query for [[Tasks0]].
     *
     * @return \yii\db\ActiveQuery|\common\models\aq\TasksQuery
     */
    public function getCustomerTasks()
    {
        return $this->hasMany(Tasks::class, ['customer_user_id' => 'id']);
    }

    /**
     * Gets query for [[UserAttachments]].
     *
     * @return \yii\db\ActiveQuery|\common\models\aq\UserAttachmentsQuery
     */
    public function getUserAttachments()
    {
        return $this->hasMany(UserAttachments::class, ['user_id' => 'id']);
    }

    /**
     * Gets query for [[UserCategories]].
     *
     * @return \yii\db\ActiveQuery|\common\models\aq\UserCategoriesQuery
     */
    public function getUserCategories()
    {
        return $this->hasMany(UserCategories::class, ['user_id' => 'id']);
    }

    /**
     * Gets query for [[UserFavorites]].
     *
     * @return \yii\db\ActiveQuery|\common\models\aq\UserFavoritesQuery
     */
    public function getUserFavorites()
    {
        return $this->hasMany(UserFavorites::class, ['favorite_user_id' => 'id']);
    }

    /**
     * Gets query for [[UserFavorites0]].
     *
     * @return \yii\db\ActiveQuery|\common\models\aq\UserFavoritesQuery
     */
    public function getUserFavorites0()
    {
        return $this->hasMany(UserFavorites::class, ['user_id' => 'id']);
    }

    /**
     * Gets query for [[UserNotifications]].
     *
     * @return \yii\db\ActiveQuery|\common\models\aq\UserNotificationsQuery
     */
    public function getUserNotifications()
    {
        return $this->hasMany(UserNotifications::class, ['user_id' => 'id']);
    }

    /**
     * Gets query for [[City]].
     *
     * @return \yii\db\ActiveQuery|\common\models\aq\CitiesQuery
     */
    public function getCity()
    {
        return $this->hasOne(Cities::class, ['id' => 'city_id']);
    }

    /**
     * {@inheritdoc}
     * @return \common\models\aq\UsersQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \common\models\aq\UsersQuery(get_called_class());
    }
}
