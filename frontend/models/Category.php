<?php

namespace frontend\models;

use common\models\Categories as BaseModel;
use frontend\models\query\CategoryQuery as Query;

/** {@inheritDoc} */
class Category extends BaseModel
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
