<?php

namespace frontend\models;

use common\models\Users as ModelsUsers;
use frontend\models\query\UsersQuery as Query;

/** {@inheritDoc} */
class Users extends ModelsUsers
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