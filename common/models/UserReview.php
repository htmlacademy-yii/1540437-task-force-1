<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "user_reviews".
 *
 * @property int $id
 * @property int $customer_user_id Заказчик
 * @property int $task_id Задание
 * @property int $rate Оценка
 * @property string|null $comment Комментарий
 * @property string $created_at Создан
 * @property string|null $updated_at Редактирован
 *
 * @property Task $task
 * @property User $customerUser
 */
class UserReview extends \yii\db\ActiveRecord
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
            [['created_at', 'updated_at'], 'safe'],
            [['task_id'], 'exist', 'skipOnError' => true, 'targetClass' => Task::className(), 'targetAttribute' => ['task_id' => 'id']],
            [['customer_user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['customer_user_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'customer_user_id' => Yii::t('app', 'Заказчик'),
            'task_id' => Yii::t('app', 'Задание'),
            'rate' => Yii::t('app', 'Оценка'),
            'comment' => Yii::t('app', 'Комментарий'),
            'created_at' => Yii::t('app', 'Создан'),
            'updated_at' => Yii::t('app', 'Редактирован'),
        ];
    }

    /**
     * Gets query for [[Task]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getTask()
    {
        return $this->hasOne(Task::className(), ['id' => 'task_id']);
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
}
