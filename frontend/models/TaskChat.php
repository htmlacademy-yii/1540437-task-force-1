<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "task_chats".
 *
 * @property int $id
 * @property int $task_id
 * @property int $user_id
 * @property string $created_at
 * @property string|null $updated_at
 * @property string|null $message
 *
 * @property Task $task
 * @property User $user
 */
class TaskChat extends \common\models\TaskChat
{

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        $rules = parent::rules();
        return $rules;
    }

    /**
     * Gets query for [[Task]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getTask()
    {
        return $this->hasOne(Task::class, ['id' => 'task_id']);
    }

    /**
     * Gets query for [[User]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::class, ['id' => 'user_id']);
    }
}
