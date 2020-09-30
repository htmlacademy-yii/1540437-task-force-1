<?php

namespace frontend\models\query;


/**
 * This is the ActiveQuery class for [[\common\models\Tasks]].
 *
 * @see \frontend\models\Tasks
 */
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

    /**
     * {@inheritdoc}
     * @return \frontend\models\Tasks[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return \frontend\models\Tasks|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}