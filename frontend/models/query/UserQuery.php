<?php

namespace frontend\models\query;

use app\bizzlogic\User;

/** {@inheritDoc} */
class UserQuery extends \yii\db\ActiveQuery
{
    /**
     * {@inheritDoc}
     *
     * @param int $minutes Unsigned
     * @return self
     */
    public function online(int $minutes = 30): self
    {
        $field = $this->_field('last_logined_at');
        return $this->andWhere(['>=', '[[last_logined_at]]', new \yii\db\Expression("NOW() - INTERVAL {$minutes} MINUTE")]);
    }

    /**
     * Имя поля, с альясом таблицы или без.
     *
     * @param string $fieldName Имя поля
     * @return string
     */
    private function _field(string $fieldName): string
    {
        list($b, $a) = $this->getTableNameAndAlias();
        return $a === $b ? $fieldName : "{$a}.{$fieldName}";
    }
}
