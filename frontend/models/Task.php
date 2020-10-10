<?php

namespace frontend\models;

use common\models\Tasks as BaseTask;
use frontend\models\query\TaskQuery as Query;

/**
 * {@inheritDoc}
 * @property TaskResponses[] $taskResponse
 * @property Categories $category
 */
class Task extends BaseTask
{
    /**
     * Query класс [[Categories]]
     *
     * @return \frontend\models\query\CategoriesQuery
     */
    public function getCategory(): \frontend\models\query\CategoryQuery
    {
        return $this->hasOne(Category::class, ['id' => 'category_id']);
    }

    /**
     * Query класс [[Cities]]
     *
     * @return \frontend\models\query\CitiesQuery
     */
    public function getCity(): \frontend\models\query\CityQuery
    {
        return $this->hasOne(City::class, ['id' => 'city_id']);
    }

    /**
     * Query класс [[TaskResponses]].
     *
     * @return \frontend\models\query\TaskResponsesQuery
     */
    public function getTaskResponses(): \frontend\models\query\TaskResponsesQuery
    {
        return $this->hasMany(TaskResponses::class, ['id' => 'task_id'])->inverseOf('task');
    }

    public function getCustomer()
    {
        return $this->hasOne(User::class, ['id' => 'customer_user_id']);
    }

    /** @return array \DateTime array values */
    public function getInterval(): array
    {
        $now = new \DateTime();
        $created = new \DateTime($this->created_at);
        return (array) $now->diff($created);
    }

    /**
     * {@inheritdoc}
     * @return Query the active query used by this AR class.
     */
    public static function find(): Query
    {
        return new Query(get_called_class());
    }
}
