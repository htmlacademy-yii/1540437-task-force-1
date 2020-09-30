<?php

namespace common\fixtures\providers;

use Faker\Provider\Base;
use app\bizzlogic\Task;

class Tasks extends Base
{
    private $command = "SELECT `id`, `budget` from `tasks` WHERE `performer_user_id` IS NULL";

    public function EmptyTasks()
    {
        $emptyTasks = $this->getCreateCommand()->queryAll();
        return random_int(1, count($emptyTasks));
    }

    private function getCreateCommand()
    {

        return \Yii::$app->db->createCommand($this->command);
        // $in = [
        //     Task::STATUS_NEW, Task::STATUS_CANCELED
        // ];
        // return strtr($this->command, [
        //     '{INCONDITION}' => implode(",", $in)
        // ]);
    }
   
}
