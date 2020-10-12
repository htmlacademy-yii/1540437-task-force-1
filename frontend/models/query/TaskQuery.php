<?php

namespace frontend\models\query;

use app\bizzlogic\Task;

/** {@inheritDoc} */
class TaskQuery extends \yii\db\ActiveQuery
{
    /** Новые задания */
    public function new()
    {
        $status = $this->_field('status');
        return $this->andWhere([$status => \app\bizzlogic\Task::STATUS_NEW]);
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
        $status = $this->_field('status');

        if ($free) {
            return $this->andWhere(['!=', $status, Task::STATUS_INPROGRESS]);
        } else {
            return $this->andWhere([$status => Task::STATUS_INPROGRESS]);
        }
    }

    public function withAddress(bool $remote = true): self
    {
        $address = $this->_field('address');
        if ($remote) {
            return $this->andWhere(['IS', $address, NULL]);
        }
        return $this->andWhere(['IS NOT', $address, NULL]);
        // return $this->andWhere([$address, $isRemote]);
    }

    /** Завершенные задания */
    public function completed()
    {
        $status = $this->_field('status');

        return $this->where([
            $status => [
                \app\bizzlogic\Task::STATUS_COMPLETE,
                \app\bizzlogic\Task::STATUS_FAIL
            ]
        ]);
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
