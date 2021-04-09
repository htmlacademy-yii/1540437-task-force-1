<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "task_responses".
 *
 * @property int $id
 * @property int|null $task_id
 * @property int|null $user_id
 * @property float|null $amount
 * @property string|null $comment
 * @property int|null $evaluation
 * @property string $created_at
 * @property string|null $updated_at
 */
class TaskResponse extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'task_responses';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['task_id', 'user_id', 'evaluation'], 'integer'],
            [['amount'], 'number'],
            [['comment'], 'string'],
            [['created_at', 'updated_at'], 'safe'],
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
            'task_id' => Yii::t('app', 'Task ID'),
            'user_id' => Yii::t('app', 'User ID'),
            'amount' => Yii::t('app', 'Amount'),
            'comment' => Yii::t('app', 'Comment'),
            'evaluation' => Yii::t('app', 'Evaluation'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
        ];
    }
}
