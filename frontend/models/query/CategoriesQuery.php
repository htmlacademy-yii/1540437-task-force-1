<?php

namespace frontend\models\query;

/**
 * This is the ActiveQuery class for [[\common\models\Categories]].
 *
 * @see \common\models\Categories
 */
class CategoriesQuery extends \yii\db\ActiveQuery
{
    /**
     * {@inheritdoc}
     * @return \frontend\models\Categories[]|array|null
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return \frontend\models\Categories|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
