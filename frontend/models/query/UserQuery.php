<?php

namespace frontend\models\query;

use app\bizzlogic\User;

/** {@inheritDoc} */
class UserQuery extends \yii\db\ActiveQuery
{
    /** Заказчики */
    public function customers()
    {
        return $this->andWhere(['role' => User::ROLE_CUSTOMER]);
    }

    /** Исполнители */
    public function performers()
    {
        return $this->andWhere(['role' => User::ROLE_PERFORMER]);
    }
}
