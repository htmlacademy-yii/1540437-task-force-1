<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "task_responses".
 *
 * @property int $id
 * @property int|null $task_id
 * @property int|null $performer_user_id Испольнитель
 * @property float|null $amount
 * @property string|null $comment
 * @property int|null $rate
 * @property string $created_at
 * @property string $updated_at
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
            [['task_id', 'performer_user_id', 'rate'], 'integer'],
            [['amount'], 'number'],
            [['comment'], 'string'],
            [['created_at', 'updated_at'], 'safe'],
            [['performer_user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['performer_user_id' => 'id']],
            [['task_id'], 'exist', 'skipOnError' => true, 'targetClass' => Task::className(), 'targetAttribute' => ['task_id' => 'id']],
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
            'performer_user_id' => Yii::t('app', 'Испольнитель'),
            'amount' => Yii::t('app', 'Amount'),
            'comment' => Yii::t('app', 'Comment'),
            'rate' => Yii::t('app', 'Rate'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
        ];
    }
}
