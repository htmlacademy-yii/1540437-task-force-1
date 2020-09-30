<?php

namespace common\fixtures\providers;

use Faker\Provider\Base;

class TasksRandomiser extends Base
{
    private $_data;

    /** @return int ID Задачи */
    public function EmptyTasks(bool $unique = false): int
    {
        $generator = $this->generator;
        if ($unique) {
            $generator->unique();
        }

        return $generator->numberBetween(1, count($this->getData()));
    }

    /** @return array|null */
    private function getData(): ?array
    {
        if (!$this->_data) {
            $this->_data = \frontend\models\Tasks::find()
                ->select(['id', 'budget'])
                ->asArray()
                ->all();
        }

        return $this->_data;
    }

    /**
     * Command with $this->command
     *
     * @return \yii\db\Command
     */
    private function getCreateCommand(): \yii\db\Command
    {
        return \Yii::$app->db->createCommand($this->command);
    }
}
