<?php

namespace common\fixtures\providers;

use Exception;
use Faker\Provider\Base;
use frontend\models\Task;

class TasksRandomiser extends Base
{
    private $_data;
    private $_completedTasks;

    /** @var \frontend\models\Task[]|null  */
    private $_tasks;

    /**
     * 
     * @param string $activeQuerykey Существующий метод класса \frontend\models\query\TaskQuery
     * @see \frontend\models\query\TaskQuery::$activeQuerykey
     * @return \frontend\models\Task[]|null
     */
    private function getTasks(string $activeQueryKey)
    {
        if (!isset($this->_tasks[$activeQueryKey])) {
            /** @var \frontend\models\query\TaskQuery $query */
            $query = \frontend\models\Task::find();

            if (!\method_exists($query, $activeQueryKey)) {
                $class = \get_class($query);
                throw new \Exception("Class '{$class}' not exists method '{$activeQueryKey}'");
            };
            $this->_tasks[$activeQueryKey] = $query->{$activeQueryKey}()->all();
        }

        return $this->_tasks[$activeQueryKey];
    }

    /**
     * 
     * @return Task|null 
     * @throws Exception 
     */
    public function completedTasks()
    {

        $task = $this->generator->randomElement($this->getTasks('done'));

        if (\is_null($task)) {
            return $task;
        }

        foreach ($this->_tasks['done'] as $k => $_task) {
            // echo "{$_k}\n";

            if ($task === $_task) {
                $this->_tasks['done'][$k] = null;

                // $this->_tasks['done'][$_k] = null;
            }
        }

        return $task;
    }

    public function getFreeTask(): ?Task
    {
        return $this->generator->randomElement(
            Task::find()->where(['performer_user_id' => null])->limit(20)->all()
        );
    }

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
