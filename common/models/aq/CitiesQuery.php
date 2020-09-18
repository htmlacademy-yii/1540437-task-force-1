<?php

namespace common\models\aq;

/**
 * This is the ActiveQuery class for [[\common\models\Cities]].
 *
 * @see \common\models\Cities
 */
class CitiesQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return \common\models\Cities[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return \common\models\Cities|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
