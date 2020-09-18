<?php

namespace common\models\aq;

/**
 * This is the ActiveQuery class for [[\common\models\UserFavorites]].
 *
 * @see \common\models\UserFavorites
 */
class UserFavoritesQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return \common\models\UserFavorites[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return \common\models\UserFavorites|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
