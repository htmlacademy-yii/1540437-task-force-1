<?php

namespace frontend\models\query;

/** {@inheritDoc} */
class TasksQuery extends \yii\db\ActiveQuery
{
    public function avaiable()
    {
        return $this->andWhere(['status' => \app\bizzlogic\Task::STATUS_NEW]);
    }

    public function completed()
    {
        return $this->andWhere([
            'status' => [
                \app\bizzlogic\Task::STATUS_COMPLETE,
                \app\bizzlogic\Task::STATUS_FAIL
            ]
        ]);
    }
}
