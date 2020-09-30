<?php

namespace common\fixtures;

use yii\test\ActiveFixture;

class TaskResponsesFixture extends ActiveFixture
{
    public $modelClass = \common\models\TaskResponses::class;
    public $depends = [
        UsersFixture::class,
        TasksFixture::class
    ];
}
