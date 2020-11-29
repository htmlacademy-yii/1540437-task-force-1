<?php

namespace frontend\models;

use common\models\TaskResponses as ModelsTasks;
use frontend\models\query\TaskResponsesQuery as Query;

/**
 * {@inheritDoc}
 * @property \frontend\models\query\TasksQuery $tasks
 * @property \frontend\models\query\UsersQuery $user
 */
class TaskResponses extends ModelsTasks
{

    /**
     * Query класса [[Task]].
     *
     * @return \frontend\models\query\TasksQuery
     */
    public function getTask(): \frontend\models\query\TaskQuery
    {
        return $this->hasOne(Tasks::class, ['id' => 'task_id'])->inverseOf('taskResponses');
    }

    /**
     * Gets query for [[User]].
     *
     * @return \frontend\models\query\UsersQuery
     */
    public function getUser(): \frontend\models\query\UserQuery
    {
        return $this->hasOne(Users::class, ['id' => 'user_id'])->inverseOf('taskReponses');
    }

    /**
     * {@inheritdoc}
     * @return Query the active query used by this AR class.
     */
    public static function find(): Query
    {
        return new Query(get_called_class());
    }
}
