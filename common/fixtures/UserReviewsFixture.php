<?php

namespace common\fixtures;

use common\models\UserReview;
use yii\test\ActiveFixture;

class UserReviewsFixture extends ActiveFixture
{
    public $modelClass = UserReview::class;
    public $depends = [
        TasksFixture::class,
        UserCategoriesFixture::class,
    ];

    public function load()
    {
        $this->data = [];
        $table = $this->getTableSchema();
        foreach ($this->getData() as $alias => $row) {
            if ($row === null) {
                continue;
            }
            $primaryKeys = $this->db->schema->insert($table->fullName, $row);
            $this->data[$alias] = array_merge($row, $primaryKeys);
        }
    }
}
