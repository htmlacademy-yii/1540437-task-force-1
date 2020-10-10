<?php

namespace frontend\models;

use common\models\Users;
use frontend\models\query\UserQuery as Query;

/**
 * {@inheritDoc}
 * @property Category[] $categories
 * @property TaskResponses[] $taskResponses
 * @property int $countPerformerTasks
 * @property int $countCustomerTasks
 */
class User extends Users
{
    /** @var float Виртуальное поле, усредненный рейтинг */
    public $avgRating;
    /** @var int Виртуапльное поле, кол-во Задач */
    public $countResponses;

    /** @return array DateInterval values */
    public function getLastLogin(): array
    {
        $timeZone = new \DateTimeZone('Europe/Moscow');
        $now = new \DateTime('now', $timeZone);
        $created = new \DateTime($this->last_logined_at, $timeZone);
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
     * Gets query for [[Tasks]].
     *
     * @return \frontend\models\query\TaskQuery
     */
    public function getPerformerTasks()
    {
        return $this->hasMany(Task::class, ['user_id' => 'id']);
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
     * Profile gender
     *
     * @return string|null
     */
    public function getGender(): ?string
    {
        return $this->profile ? $this->profile->gender : null;
    }

    /**
     * Profile Last name
     * 
     * @return string|null
     */
    public function getLastName(): ?string
    {
        return $this->profile ? $this->profile->last_name : null;
    }

    /**
     * Profile First name
     *
     * @return string|null
     */
    public function getFirstName(): ?string
    {
        return $this->profile ? $this->profile->first_name : null;
    }

    /**
     * @return Query the active query used by this AR class.
     */
    public static function find(): Query
    {
        return new Query(get_called_class());
    }
}
