<?php

namespace frontend\models;

use common\models\Cities as BaseModel;
use frontend\models\query\CityQuery as Query;

/** {@inheritDoc} */
class City extends BaseModel
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
