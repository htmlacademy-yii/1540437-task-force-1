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

    /** 
     * Свободные или занятые пользователи.
     * По умолчанию, пользователи без активных заданий.
     * 
     * @param bool $free по умолчанию true
     * @return self
     */
    public function free(bool $free = true): self
    {
        $statusField = $this->_field('');

        if ($free) {
            return $this->andWhere(['!=', '[[status]]', Task::STATUS_INPROGRESS]);
        } else {
            return $this->andWhere(['[[status]]' => Task::STATUS_INPROGRESS]);
        }
    }

    /**
     * Ели допускается удаленная работа (без привязки к адресу)
     *
     * @param string $fieldName Deafult `address` 
     * @param boolean $remote Default `true`
     * @return self
     */
    public function remoteWork(bool $remote = true, string $fieldName = 'address'): self
    {
        $is = $remote ? 'IS' : 'IS NOT';
        return $this->andWhere([$is, $fieldName, NULL]);
    }

    /**
     * Undocumented function
     *
     * @param array[int] $categoryIds 
     * @param string $aliase Deafult `null`
     * @return self
     */
    public function inCategories(array $categoryIds, string $aliase = null): self
    {
        if (!is_null($aliase)) {
            $aliase = $aliase . ".";
        }
        return $this->andWhere(["{$aliase}category_id" => $categoryIds]);
    }

    /** Завершенные задания */
    public function completed()
    {
        $statusField = $this->_field('status');

        return $this->where([
            $statusField => [
                \app\bizzlogic\Task::STATUS_COMPLETE,
                \app\bizzlogic\Task::STATUS_FAIL
            ]
        ]);
    }

    /**
     * Условия выборки для периода
     *
     * @param string $fieldName Имя поля по которому выполнять поиск
     * @param string $periodName Наименование периода
     * @return self
     */
    public function byPeriod(string $fieldName, string $periodName): self
    {
        return $this->andWhere(['>=', $fieldName, new \yii\db\Expression("NOW() - INTERVAL 1  " . strtoupper($periodName))]);
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
