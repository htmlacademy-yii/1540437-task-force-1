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

    /**
     * {@inheritDoc}
     *
     * @param int $minutes Unsigned
     * @return self
     */
    public function online(int $minutes = 30): self
    {
        list($b, $a) = $this->getTableNameAndAlias();
        $expression = "NOW() - INTERVAL {$minutes} MINUTE";
        return $this->andWhere(['>=', "{$a}.last_logined_at", new \yii\db\Expression($expression)]);
    }
}
