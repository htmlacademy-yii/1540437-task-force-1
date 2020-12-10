<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "user_reviews".
 *
 * @property int $id
 * @property int $customer_user_id Customer
 * @property int $task_id Task
 * @property int $rate Rating
 * @property string|null $comment Comment
 * @property string $created_at Created
 *
 * @property Task $task
 * @property User $customerUser
 */
class UserReviews extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'user_reviews';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['customer_user_id', 'task_id', 'rate'], 'required'],
            [['customer_user_id', 'task_id', 'rate'], 'integer'],
            [['comment'], 'string'],
            [['created_at'], 'safe'],
            [['task_id'], 'exist', 'skipOnError' => true, 'targetClass' => Tasks::class, 'targetAttribute' => ['task_id' => 'id']],
            [['customer_user_id'], 'exist', 'skipOnError' => true, 'targetClass' => Users::class, 'targetAttribute' => ['customer_user_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'customer_user_id' => Yii::t('app', 'Customer'),
            'task_id' => Yii::t('app', 'Task'),
            'rate' => Yii::t('app', 'Rating'),
            'comment' => Yii::t('app', 'Comment'),
            'created_at' => Yii::t('app', 'Created'),
        ];
    }

    /**
     * Gets query for [[Task]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getTask()
    {
        return $this->hasOne(Tasks::class, ['id' => 'task_id']);
    }

    /**
     * Gets query for [[CustomerUser]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCustomerUser()
    {
        return $this->hasOne(Users::class, ['id' => 'customer_user_id']);
    }
}
