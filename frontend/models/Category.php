<?php

namespace frontend\models;

use frontend\models\query\CategoryQuery;
use frontend\models\query\UserQuery;
use Yii;

/**
 * This is the model class for table "categories".
 *
 * @property int $id
 * @property string $name
 * @property string|null $icon
 *
 * @property Task[] $tasks
 * @property User[] $users
 */
class Category extends \common\models\Category
{

    /**
     * Gets query for [[Tasks]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getTasks()
    {
        return $this->hasMany(Task::class, ['category_id' => 'id']);
    }

    /**
     * Query class for User model
     *
     * @return UserQuery
     */
    public function getUsers(): UserQuery
    {
        return $this->hasMany(User::class,  ['id' => 'user_id'])
            ->viaTable('user_categories', ['category_id' => 'id' ]);
    }

    /** @return CategoryQuery */
    public static function find(): CategoryQuery
    {
        return new CategoryQuery(get_called_class());
    }
}
