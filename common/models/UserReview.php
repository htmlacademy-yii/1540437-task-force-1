<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "user_reviews".
 *
 * @property int $id
 * @property int|null $user_id Customer
 * @property int|null $task_id Task
 * @property int $rate Rating
 * @property string|null $comment
 * @property string $created_at Created
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
            [['user_id', 'task_id', 'rate'], 'integer'],
            [['rate'], 'required'],
            [['comment'], 'string'],
            [['created_at'], 'safe'],
            [['task_id'], 'exist', 'skipOnError' => true, 'targetClass' => Task::className(), 'targetAttribute' => ['task_id' => 'id']],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'user_id' => Yii::t('app', 'Customer'),
            'task_id' => Yii::t('app', 'Task'),
            'rate' => Yii::t('app', 'Rating'),
            'comment' => Yii::t('app', 'Comment'),
            'created_at' => Yii::t('app', 'Created'),
        ];
    }
}
