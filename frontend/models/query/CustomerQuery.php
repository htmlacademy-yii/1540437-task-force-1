<?php

namespace frontend\models\query;

/** {@inheritDoc} */
class CustomerQuery extends \yii\db\ActiveQuery
{

    public function init()
    {
        $this->joinWith('userCategories')->andOnCondition([
            'userCategories.category_id' => NULL
        ]);
        parent::init();
    }

    /**
     * {@inheritDoc}
     *
     * @param int $minutes Unsigned
     * @return self
     */
    public function online(int $minutes = 30): self
    {
        $field = $this->_field('last_logined_at');
        return $this->andWhere(['>=', $field, new \yii\db\Expression("NOW() - INTERVAL {$minutes} MINUTE")]);
    }

    /**
     * Имя поля, с альясом таблицы или без.
     *
     * @param string $fieldName Имя поля
     * @return string
     */
    private function _field(string $fieldName): string
    {
        list($tbaleName, $aliase) = $this->getTableNameAndAlias();
        return $aliase === $tbaleName ? "{$tbaleName}.{$fieldName}" : "{$aliase}.{$fieldName}";
    }
}
