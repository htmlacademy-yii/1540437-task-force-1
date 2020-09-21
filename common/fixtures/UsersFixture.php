<?php

namespace common\fixtures;

use yii\test\ActiveFixture;
use common\models\Users;

class UsersFixture extends ActiveFixture
{
    public $modelClass = Users::class;
    public $count = 20;
}