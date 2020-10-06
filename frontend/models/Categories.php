<?php

namespace frontend\models;

use common\models\Categories as Models;
use frontend\models\query\CategoriesQuery as Query;

/** {@inheritDoc} */
class Categories extends Models
{
    /**
     * {@inheritdoc}
     * @return Query the active query used by this AR class.
     */
    public static function find(): Query
    {
        return new Query(get_called_class());
    }
}
