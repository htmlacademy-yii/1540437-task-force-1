<?php

namespace frontend\models\query;

use app\bizzlogic\User;

class UsersQuery extends \yii\db\ActiveQuery
{
    public function asRole(string $role)
    {
        if (in_array($role, array_keys(User::roleMap()))) {
            return $this->andWhere(['role' => $role]);
        }

        return $this;
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