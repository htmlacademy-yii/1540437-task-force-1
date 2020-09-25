<?php

namespace frontend\models\query;

use app\bizzlogic\User;

class UsersQuery extends \yii\db\ActiveQuery
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

    /**
     * {@inheritdoc}
     * @return \frontend\models\Users[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return \frontend\models\Users|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
