<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "tasks".
 *
 * @property int $id
 * @property int $user_id
 * @property int|null $performer_user_id
 * @property int|null $category_id
 * @property string|null $title
 * @property string $description
 * @property string|null $additional_info
 * @property string|null $address
 * @property string|null $status
 * @property float|null $budget
 * @property string|null $expire
 * @property float|null $latitude
 * @property float|null $longitude
 * @property string $created_at
 * @property string|null $updated_at
 * @property string|null $published_at
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
            [['user_id', 'description'], 'required'],
            [['user_id', 'performer_user_id', 'category_id'], 'integer'],
            [['description', 'additional_info', 'address', 'status'], 'string'],
            [['budget', 'latitude', 'longitude'], 'number'],
            [['expire', 'created_at', 'updated_at', 'published_at'], 'safe'],
            [['title'], 'string', 'max' => 256],
            [['category_id'], 'exist', 'skipOnError' => true, 'targetClass' => Category::className(), 'targetAttribute' => ['category_id' => 'id']],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
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
            'user_id' => Yii::t('app', 'User ID'),
            'performer_user_id' => Yii::t('app', 'Performer User ID'),
            'category_id' => Yii::t('app', 'Category ID'),
            'title' => Yii::t('app', 'Title'),
            'description' => Yii::t('app', 'Description'),
            'additional_info' => Yii::t('app', 'Additional Info'),
            'address' => Yii::t('app', 'Address'),
            'status' => Yii::t('app', 'Status'),
            'budget' => Yii::t('app', 'Budget'),
            'expire' => Yii::t('app', 'Expire'),
            'latitude' => Yii::t('app', 'Latitude'),
            'longitude' => Yii::t('app', 'Longitude'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
            'published_at' => Yii::t('app', 'Published At'),
        ];
    }
}
