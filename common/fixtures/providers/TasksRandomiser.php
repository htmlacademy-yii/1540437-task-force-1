<?php

namespace common\fixtures\providers;

use Faker\Provider\Base;
use frontend\models\Task;

class TasksRandomiser extends Base
{
    private $_data;
    private $_completedTasks;

    /** @return int ID Задачи */
    public function EmptyTasks(bool $unique = false): int
    {
        $generator = $this->generator;
        if ($unique) {
            $generator->unique();
        }

        return $generator->numberBetween(1, count($this->getData()));
    }

    public function completedTask(bool $unique = false): int
    {
        $generator = $this->generator;
        if ($unique) {
            $generator->unique();
        }

        if (!$this->_completedTasks) {
            $this->_completedTasks = Task::find()->asArray()->all();
        }

        return $generator->numberBetween(1, count($this->_completedTasks));
    }

    /** @return array|null */
    private function getData(): ?array
    {
        if (!$this->_data) {
            $this->_data = \frontend\models\Task::find()
                ->select(['id', 'budget'])
                ->asArray()
                ->all();
        }

        return $this->_data;
    }
}
