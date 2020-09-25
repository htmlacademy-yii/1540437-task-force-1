<?php

namespace common\fixtures;

use common\models\UserCategories;
use yii\test\ActiveFixture;

class UserCategoriesFixture extends ActiveFixture
{
    public $modelClass = UserCategories::class;
    // public $depends = [
    //     UsersFixture::class
    // ];
}
