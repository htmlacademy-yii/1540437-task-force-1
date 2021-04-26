<?php

namespace frontend\models;

use frontend\models\query\TaskQuery;
use frontend\models\query\TaskResponseQuery;
use frontend\models\query\UserQuery;

/**
 * This is the model class for table "task_responses".
 *
 * @property Task $task
 * @property User $performer Исполнитель
 * @property User $customer Заказчик
 */
class TaskResponse extends \common\models\TaskResponse
{

    /**
     * Gets query for [[Task]].
     *
     * @return TaskQuery
     */
    public function getTask(): TaskQuery
    {
        return $this->hasOne(Task::class, ['id' => 'task_id']);
    }

    /** Заказчик */
    public function getCustomer(): UserQuery
    {
        return $this->hasOne(User::class, ['id' => 'user_id'])
            ->via('task');
    }

    public function getPerformer(): UserQuery
    {
        return $this->hasOne(User::class, ['id' => 'performer_user_id']);
    }

    /**
     * {@inheritdoc}
     * @return Query the active query used by this AR class.
     */
    public static function find(): TaskResponseQuery
    {
        return new TaskResponseQuery(get_called_class());
    }
}
