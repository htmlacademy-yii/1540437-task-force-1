<?php

namespace common\fixtures;

use yii\test\ActiveFixture;
use common\models\Tasks;

class TasksFixture extends ActiveFixture
{
    public $modelClass = Tasks::class;
    public $depends = [
        UsersFixture::class
    ];
}