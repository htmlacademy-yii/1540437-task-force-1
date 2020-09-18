<?php

namespace common\models\aq;

/**
 * This is the ActiveQuery class for [[\common\models\TaskMessages]].
 *
 * @see \common\models\TaskMessages
 */
class TaskMessagesQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return \common\models\TaskMessages[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return \common\models\TaskMessages|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
