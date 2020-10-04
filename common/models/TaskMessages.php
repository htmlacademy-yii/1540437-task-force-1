<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "task_messages".
 *
 * @property int $id
 * @property int $task_id
 * @property int $user_id
 * @property string $created_at
 * @property string|null $updated_at
 * @property string|null $message
 */
class TaskMessages extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'task_messages';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['task_id', 'user_id'], 'required'],
            [['task_id', 'user_id'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['message'], 'string'],
            [['task_id'], 'exist', 'skipOnError' => true, 'targetClass' => Tasks::class, 'targetAttribute' => ['task_id' => 'id']],
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
            'task_id' => Yii::t('app', 'Task ID'),
            'user_id' => Yii::t('app', 'User ID'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
            'message' => Yii::t('app', 'Message'),
        ];
    }
}
