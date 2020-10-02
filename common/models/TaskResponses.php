<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "task_responses".
 *
 * @property int $id
 * @property int $task_id
 * @property int $user_id
 * @property float|null $price
 * @property string|null $comment
 * @property int|null $evaluation
 * @property int|null $is_success
 * @property string $created_at
 * @property string|null $updated_at
 *
 * @property Tasks $task
 * @property Users $user
 */
class TaskResponses extends \yii\db\ActiveRecord
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
            [['task_id', 'user_id'], 'required'],
            [['task_id', 'user_id', 'evaluation', 'is_success'], 'integer'],
            [['price'], 'number'],
            [['comment'], 'string'],
            [['created_at', 'updated_at'], 'safe'],
            [['task_id'], 'exist', 'skipOnError' => true, 'targetClass' => Tasks::className(), 'targetAttribute' => ['task_id' => 'id']],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['user_id' => 'id']],
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
            'price' => Yii::t('app', 'Price'),
            'comment' => Yii::t('app', 'Comment'),
            'evaluation' => Yii::t('app', 'Evaluation'),
            'is_success' => Yii::t('app', 'Is Success'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
        ];
    }

    /**
     * Gets query for [[Task]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getTask()
    {
        return $this->hasOne(Tasks::className(), ['id' => 'task_id'])->inverseOf('taskResponses');
    }

    /**
     * Gets query for [[User]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(Users::className(), ['id' => 'user_id'])->inverseOf('taskResponses');
    }
}
