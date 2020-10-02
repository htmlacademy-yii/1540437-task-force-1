<?php

namespace frontend\models;

use common\models\Tasks as ModelsTasks;
use frontend\models\query\TasksQuery as Query;

/**
 * {@inheritDoc}
 * @property TaskResponses[] $taskResponse
 * @property Categories $category
 * @property Cities $city
 */
class Tasks extends ModelsTasks
{

    /**
     * Query класс [[Categories]]
     *
     * @return \frontend\models\query\CategoriesQuery
     */
    public function getCategory(): \frontend\models\query\CategoriesQuery
    {
        return $this->hasOne(Categories::class, ['id' => 'category_id']);
    }

    /**
     * Query класс [[Cities]]
     *
     * @return \frontend\models\query\CitiesQuery
     */
    public function getCity(): \frontend\models\query\CitiesQuery
    {
        return $this->hasOne(Cities::class, ['id' => 'city_id']);
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

    /** @return array */
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
