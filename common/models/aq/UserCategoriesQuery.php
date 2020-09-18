<?php

namespace common\models\aq;

/**
 * This is the ActiveQuery class for [[\common\models\UserCategories]].
 *
 * @see \common\models\UserCategories
 */
class UserCategoriesQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return \common\models\UserCategories[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return \common\models\UserCategories|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
