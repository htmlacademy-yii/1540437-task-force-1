<?php

namespace common\fixtures;

use common\models\Task;
use yii\test\ActiveFixture;

class TasksFixture extends ActiveFixture
{
    public $modelClass = Task::class;
    public $depends = [
        \common\fixtures\UsersFixture::class
    ];
}
