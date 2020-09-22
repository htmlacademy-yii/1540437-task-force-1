<?php

namespace frontend\models;

use common\models\Tasks as ModelsTasks;
use frontend\models\query\TasksQuery as Query;

/** {@inheritDoc} */
class Tasks extends ModelsTasks
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