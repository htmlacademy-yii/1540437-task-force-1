<?php

namespace common\fixtures;

use yii\test\ActiveFixture;
use common\models\User;

class UsersFixture extends ActiveFixture
{
    public $modelClass = User::class;
    public $depends = [
        UserProfileFixture::class
    ];
}
