<?php

namespace frontend\models\query;

use app\bizzlogic\User;

/** {@inheritDoc} */
class UserQuery extends \yii\db\ActiveQuery
{
    /** Заказчики */
    public function customers()
    {
        list($b, $a) = $this->getTableNameAndAlias();
        return $this->andWhere(["{$a}.role" => User::ROLE_CUSTOMER]);
    }

    /** Исполнители */
    public function performers()
    {
        list($b, $a) = $this->getTableNameAndAlias();
        return $this->andWhere(["{$a}.role" => User::ROLE_PERFORMER]);
    }
}
