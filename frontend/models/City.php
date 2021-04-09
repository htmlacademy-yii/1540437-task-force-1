<?php

namespace frontend\models;

use frontend\models\query\CityQuery;
use Yii;

/**
 * This is the model class for table "cities".
 *
 * @property int $id
 * @property string|null $name
 * @property float|null $lattitude
 * @property float|null $longtitude
 *
 * @property Task[] $tasks
 * @property User[] $users
 */
class City extends \common\models\City
{

    /**
     * Gets query for [[Tasks]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getTasks()
    {
        return $this->hasMany(Task::class, ['city_id' => 'id']);
    }

    /**
     * Gets query for [[Users]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUsers()
    {
        return $this->hasMany(User::class, ['city_id' => 'id']);
    }

    /** @return CityQuery */
    public static function find(): CityQuery
    {
        return new CityQuery(get_called_class());
    }
}
