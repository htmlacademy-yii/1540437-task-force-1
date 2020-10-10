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

    public function active()
    {
        $status = $this->_field('status');

        return $this->andWhere(['in', $status, [
            Task::STATUS_NEW,
            Task::STATUS_INPROGRESS
        ]]);
    }

    public function notActive()
    {
        $status = $this->_field('status');
        return $this->andWhere(['not in', $status, [
            Task::STATUS_NEW,
            Task::STATUS_INPROGRESS
        ]]);
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

    /** Без активных заданий */
    public function nowFree()
    {
        $performer = $this->_field('performer_user_id');
        return $this->andWhere([$performer => null]);
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
