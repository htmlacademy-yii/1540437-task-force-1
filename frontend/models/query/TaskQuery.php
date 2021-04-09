<?php

namespace frontend\models\query;

use app\bizzlogic\Task;

/** {@inheritDoc} */
class TaskQuery extends \yii\db\ActiveQuery
{
    /** Новые задания */
    public function new()
    {
        $statusField = $this->_field('status');
        return $this->andWhere([$statusField => \app\bizzlogic\Task::STATUS_NEW]);
    }

    public function inProgress()
    {
        $fieldName = $this->_field('status');
        return $this->andWhere([$fieldName => Task::STATUS_INPROGRESS]);
    }

    /**
     * Еcли допускается удаленная работа (без привязки к адресу)
     *
     * @param boolean $remote Default `true`
     * @return self
     */
    public function remoteWork(bool $remote = true): self
    {
        $fieldName = $this->_field('address');
        $is = $remote ? 'IS' : 'IS NOT';
        return $this->andWhere([$is, $fieldName, NULL]);
    }

    /**
     * Undocumented function
     *
     * @param array[int] $categoryIds 
     * @return self
     */
    public function inCategories(array $categoryIds): self
    {
        $fieldName = $this->_field('category_id');
        return $this->andOnCondition([$fieldName => $categoryIds]);
    }

    /** Завершенные задания */
    public function completed(): self
    {
        $fieldName = $this->_field('status');
        return $this->where([
            $fieldName => [
                \app\bizzlogic\Task::STATUS_COMPLETE,
                \app\bizzlogic\Task::STATUS_FAIL
            ]
        ]);
    }

    /**
     * Условия выборки для периода
     *
     * @param string $periodName Наименование периода
     * @return self
     */
    public function byPeriod(string $periodName): self
    {
        $fieldName = $this->_field('created_at');
        return $this->andWhere(['>=', $fieldName, new \yii\db\Expression("NOW() - INTERVAL 1  " . strtoupper($periodName))]);
    }

    public function performers(): self
    {
        $fieldName = $this->_field('performer_user_id');
        return $this->andWhere([$fieldName => '']);
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
