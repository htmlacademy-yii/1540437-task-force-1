<?php

namespace frontend\models;

use common\models\Users as BaseUser;
use frontend\models\query\UserQuery as Query;

/**
 * {@inheritDoc}
 * @property \frontend\models\query\CategoryQuery[] $categories
 * @property \frontend\models\query\TaskQuery[] $performerTasks
 * @property \frontend\models\query\TaskQuery[] $customersTasks
 * @property \frontend\models\query\TaskResponsesQuery[] $taskResponses
 * @property int $countPerformerTasks
 * @property int $countCustomerTasks
 */
class User extends BaseUser
{

    /** @var float Виртуальное поле, усредненный рейтинг */
    public $avgRating;
    /** @var int Виртуапльное поле, кол-во Задач */
    public $countResponses;

    /** @return array DateInterval values */
    public function getLastLogin(): array
    {
        $now = new \DateTime();
        $created = new \DateTime($this->last_logined_at);
        return (array) $now->diff($created);
    }

    /**
     * Gets query for [[Category]].
     *
     * @return \frontend\models\query\CategoryQuery
     */
    public function getCategories(): \frontend\models\query\CategoryQuery
    {
        return $this->hasMany(Category::class, ['id' => 'category_id'])
            ->viaTable('user_categories', ['user_id' => 'id']);
    }

    /**
     * Gets query for [[TaskResponses]].
     *
     * @return \frontend\models\query\TaskResponsesQuery
     */
    public function getTaskResponses(): \frontend\models\query\TaskResponsesQuery
    {
        return $this->hasMany(TaskResponses::class, ['user_id' => 'id']);
    }

    /**
     * Gets query for [[Tasks]].
     *
     * @return \frontend\models\query\TaskQuery
     */
    public function getPerformerTasks(): \frontend\models\query\TaskQuery
    {
        return $this->hasMany(Task::class, ['performer_user_id' => 'id']);
    }

    /**
     * Gets query for [[Tasks]].
     *
     * @return \frontend\models\query\TaskQuery
     */
    public function getCustomerTasks(): \frontend\models\query\TaskQuery
    {
        return $this->hasMany(Task::class, ['customer_user_id' => 'id']);
    }

    /** @return int Кол-во Заданий Исполнителя */
    public function getCountPerformerTasks(): int
    {
        return (int) count($this->performerTasks);
    }

    /** @return int|string Кол-во Заданий заказчика */
    public function getCountCustomerTasks(): int
    {
        return (int) count($this->customerTasks);
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
