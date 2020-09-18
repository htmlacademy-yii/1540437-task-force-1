<?php

namespace common\models\aq;

/**
 * This is the ActiveQuery class for [[\common\models\Categories]].
 *
 * @see \common\models\Categories
 */
class CategoriesQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return \common\models\Categories[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return \common\models\Categories|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
