<?php

namespace frontend\models\query;

/** {@inheritDoc} */
class PerformerQuery extends \yii\db\ActiveQuery
{

    public function init()
    {
        $field = $this->_field('id');
        $this->andOnCondition([$field => \common\models\UserCategory::find()->select('user_id')->distinct()]);
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
