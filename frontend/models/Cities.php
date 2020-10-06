<?php

namespace frontend\models;

use common\models\Cities as Models;
use frontend\models\query\CitiesQuery as Query;

/** {@inheritDoc} */
class Cities extends Models
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
