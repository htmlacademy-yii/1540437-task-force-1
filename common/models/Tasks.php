<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "tasks".
 *
 * @property int $id
 * @property int $customer_user_id
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
<<<<<<< HEAD
 * @property TaskMessages[] $taskMessages
 * @property TaskResponses[] $taskResponses
 * @property Categories $category
 * @property Cities $city
 * @property Users $customerUser
 * @property Users $performerUser
 * @property UserAttachments[] $userAttachments
=======
>>>>>>> 3bd84bf7b0f177b8b24981b055b0376d4831b0b3
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
            [['customer_user_id', 'category_id', 'city_id', 'description'], 'required'],
            [['customer_user_id', 'performer_user_id', 'category_id', 'city_id'], 'integer'],
            [['description', 'additional_info', 'address', 'status'], 'string'],
            [['budget', 'lattitude', 'longtitude'], 'number'],
            [['created_at', 'updated_at', 'start_date'], 'safe'],
            [['title'], 'string', 'max' => 256],
            [['category_id'], 'exist', 'skipOnError' => true, 'targetClass' => Categories::className(), 'targetAttribute' => ['category_id' => 'id']],
            [['city_id'], 'exist', 'skipOnError' => true, 'targetClass' => Cities::className(), 'targetAttribute' => ['city_id' => 'id']],
            [['customer_user_id'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['customer_user_id' => 'id']],
            [['performer_user_id'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['performer_user_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'customer_user_id' => Yii::t('app', 'Customer User ID'),
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
}
