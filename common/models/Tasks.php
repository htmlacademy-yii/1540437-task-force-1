<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "tasks".
 *
 * @property int $id
 * @property int $user_id
 * @property int|null $performer_user_id
 * @property int $category_id
 * @property int $city_id
 * @property string|null $title
 * @property string $description
 * @property string|null $additional_info
 * @property string|null $address
 * @property string $status
 * @property float|null $budget
 * @property string $created_at
 * @property string|null $updated_at
 * @property string|null $start_date
 * @property float|null $lattitude
 * @property float|null $longtitude
 *
 * @property TaskMessages[] $taskMessages
 * @property TaskResponses[] $taskResponses
 * @property Categories $category
 * @property Cities $city
 * @property Users $performerUser
 * @property Users $user
 * @property UserAttachments[] $userAttachments
 */
class Tasks extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tasks';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id', 'category_id', 'city_id', 'description'], 'required'],
            [['user_id', 'performer_user_id', 'category_id', 'city_id'], 'integer'],
            [['description', 'additional_info', 'address', 'status'], 'string'],
            [['budget', 'lattitude', 'longtitude'], 'number'],
            [['created_at', 'updated_at', 'start_date'], 'safe'],
            [['title'], 'string', 'max' => 256],
            [['category_id'], 'exist', 'skipOnError' => true, 'targetClass' => Categories::class, 'targetAttribute' => ['category_id' => 'id']],
            [['city_id'], 'exist', 'skipOnError' => true, 'targetClass' => Cities::class, 'targetAttribute' => ['city_id' => 'id']],
            [['performer_user_id'], 'exist', 'skipOnError' => true, 'targetClass' => Users::class, 'targetAttribute' => ['performer_user_id' => 'id']],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => Users::class, 'targetAttribute' => ['user_id' => 'id']],
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
            'performer_user_id' => Yii::t('app', 'Performer User ID'),
            'category_id' => Yii::t('app', 'Category ID'),
            'city_id' => Yii::t('app', 'City ID'),
            'title' => Yii::t('app', 'Title'),
            'description' => Yii::t('app', 'Description'),
            'additional_info' => Yii::t('app', 'Additional Info'),
            'address' => Yii::t('app', 'Address'),
            'status' => Yii::t('app', 'Status'),
            'budget' => Yii::t('app', 'Budget'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
            'start_date' => Yii::t('app', 'Start Date'),
            'lattitude' => Yii::t('app', 'Lattitude'),
            'longtitude' => Yii::t('app', 'Longtitude'),
        ];
    }

    /**
     * Gets query for [[TaskMessages]].
     *
     * @return \yii\db\ActiveQuery|\common\models\aq\TaskMessagesQuery
     */
    public function getTaskMessages()
    {
        return $this->hasMany(TaskMessages::class, ['task_id' => 'id']);
    }

    /**
     * Gets query for [[TaskResponses]].
     *
     * @return \yii\db\ActiveQuery|\common\models\aq\TaskResponsesQuery
     */
    public function getTaskResponses()
    {
        return $this->hasMany(TaskResponses::class, ['task_id' => 'id']);
    }

    /**
     * Gets query for [[Category]].
     *
     * @return \yii\db\ActiveQuery|\common\models\aq\CategoriesQuery
     */
    public function getCategory()
    {
        return $this->hasOne(Categories::class, ['id' => 'category_id']);
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
     * Gets query for [[PerformerUser]].
     *
     * @return \yii\db\ActiveQuery|\common\models\aq\UsersQuery
     */
    public function getPerformerUser()
    {
        return $this->hasOne(Users::class, ['id' => 'performer_user_id']);
    }

    /**
     * Gets query for [[User]].
     *
     * @return \yii\db\ActiveQuery|\common\models\aq\UsersQuery
     */
    public function getCustomerUser()
    {
        return $this->hasOne(Users::class, ['id' => 'user_id']);
    }

    /**
     * Gets query for [[UserAttachments]].
     *
     * @return \yii\db\ActiveQuery|\common\models\aq\UserAttachmentsQuery
     */
    public function getUserAttachments()
    {
        return $this->hasMany(UserAttachments::class, ['task_id' => 'id']);
    }

    /**
     * {@inheritdoc}
     * @return \common\models\aq\TasksQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \common\models\aq\TasksQuery(get_called_class());
    }
}
