<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "tasks".
 *
 * @property int $id
 * @property int $city_id Город
 * @property int $customer_user_id Заказчик
 * @property int|null $performer_user_id Исполнитель
 * @property int $category_id Категория
 * @property string|null $title Титул
 * @property string $description Описание
 * @property string|null $additional_info Дополнительная информация
 * @property string|null $address Адресс
 * @property string $status Статус
 * @property float|null $budget Бюджет
 * @property string $created_at Создано
 * @property string|null $updated_at Отредактировано
 * @property string|null $start_date Начать
 * @property float|null $latitude Широта
 * @property float|null $longtitude Долгота
 *
 * @property TaskChat[] $taskChats
 * @property TaskResponse[] $taskResponses
 * @property Category $category
 * @property City $city
 * @property User $customerUser
 * @property User $performerUser
 * @property UserAttachment[] $userAttachments
 * @property UserReview[] $userReviews
 */
class Task extends \yii\db\ActiveRecord
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
            [['city_id', 'customer_user_id', 'category_id', 'description'], 'required'],
            [['city_id', 'customer_user_id', 'performer_user_id', 'category_id'], 'integer'],
            [['description', 'additional_info', 'address', 'status'], 'string'],
            [['budget', 'latitude', 'longtitude'], 'number'],
            [['created_at', 'updated_at', 'start_date'], 'safe'],
            [['title'], 'string', 'max' => 256],
            [['category_id'], 'exist', 'skipOnError' => true, 'targetClass' => Category::className(), 'targetAttribute' => ['category_id' => 'id']],
            [['city_id'], 'exist', 'skipOnError' => true, 'targetClass' => City::className(), 'targetAttribute' => ['city_id' => 'id']],
            [['customer_user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['customer_user_id' => 'id']],
            [['performer_user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['performer_user_id' => 'id']],
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
            'customer_user_id' => Yii::t('app', 'Заказчик'),
            'performer_user_id' => Yii::t('app', 'Исполнитель'),
            'category_id' => Yii::t('app', 'Категория'),
            'title' => Yii::t('app', 'Титул'),
            'description' => Yii::t('app', 'Описание'),
            'additional_info' => Yii::t('app', 'Дополнительная информация'),
            'address' => Yii::t('app', 'Адресс'),
            'status' => Yii::t('app', 'Статус'),
            'budget' => Yii::t('app', 'Бюджет'),
            'created_at' => Yii::t('app', 'Создано'),
            'updated_at' => Yii::t('app', 'Отредактировано'),
            'start_date' => Yii::t('app', 'Начать'),
            'latitude' => Yii::t('app', 'Широта'),
            'longtitude' => Yii::t('app', 'Долгота'),
        ];
    }

    /**
     * Gets query for [[TaskChats]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getTaskChats()
    {
        return $this->hasMany(TaskChat::className(), ['task_id' => 'id']);
    }

    /**
     * Gets query for [[TaskResponses]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getTaskResponses()
    {
        return $this->hasMany(TaskResponse::className(), ['task_id' => 'id']);
    }

    /**
     * Gets query for [[Category]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCategory()
    {
        return $this->hasOne(Category::className(), ['id' => 'category_id']);
    }

    /**
     * Gets query for [[City]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCity()
    {
        return $this->hasOne(City::className(), ['id' => 'city_id']);
    }

    /**
     * Gets query for [[CustomerUser]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCustomerUser()
    {
        return $this->hasOne(User::className(), ['id' => 'customer_user_id']);
    }

    /**
     * Gets query for [[PerformerUser]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPerformerUser()
    {
        return $this->hasOne(User::className(), ['id' => 'performer_user_id']);
    }

    /**
     * Gets query for [[UserAttachments]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUserAttachments()
    {
        return $this->hasMany(UserAttachment::className(), ['task_id' => 'id']);
    }

    /**
     * Gets query for [[UserReviews]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUserReviews()
    {
        return $this->hasMany(UserReview::className(), ['task_id' => 'id']);
    }
}
