<?php

namespace common\models\aq;

/**
 * This is the ActiveQuery class for [[\common\models\Tasks]].
 *
 * @see \common\models\Tasks
 */
class TasksQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return \common\models\Tasks[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return \common\models\Tasks|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
