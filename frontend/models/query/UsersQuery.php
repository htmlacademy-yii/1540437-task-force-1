<?php

namespace frontend\models\query;

class UsersQuery extends \yii\db\ActiveQuery
{
    public function customers()
    {
        return $this->andWhere('[[role]]=' . \app\bizzlogic\User::ROLE_CUSTOMER);
    }

    public function performer()
    {
        return $this->andWhere('[[role]]=' . \app\bizzlogic\User::ROLE_PERFORMER);
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