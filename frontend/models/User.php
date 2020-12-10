<?php

namespace frontend\models;

use DateTime;
use frontend\models\query\TaskResponsesQuery;
use frontend\models\query\UserQuery as Query;

/**
 * {@inheritDoc}
 * @property Category[] $categories
 * @property TaskResponses[] $taskResponses
 * @property int $countPerformerTasks
 * @property int $countCustomerTasks
 * @property array $registerDateInterval Interval Datetime as array
 * @property string $birthDate Дата рождения
 * @property string $skype
 * @property string $phone
 */
class User extends \common\models\Users
{
    /** @var float Виртуальное поле, усредненный рейтинг */
    public $avgRating;
    /** @var int Виртуапльное поле, кол-во Задач */
    public $countResponses;

    /** @return array DateInterval values */
    public function getLastLogin(): array
    {
        $now = new \DateTime('now');
        $created = new \DateTime($this->last_logined_at);
        return (array) $now->diff($created);
    }

    // /**
    //  * Undocumented function
    //  *
    //  * @return TaskResponsesQuery
    //  */
    // public function getTaskResponses(): TaskResponsesQuery
    // {
    //     return $this->hasMany(TaskResponses::class, ['user_id' => 'id'])
    //         ->inverseOf('user');
    // }

    public function getRegisterDateInterval(): array
    {
        $now = new \DateTime('now');
        $created = new \DateTime($this->created_at);
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
            ->via('userCategories');
    }

    /**
     * Gets query for [[Task]].
     *
     * @return \frontend\models\query\TaskQuery
     */
    public function getCustomerTasks()
    {
        return $this->hasMany(Task::class, ['customer_user_id' => 'id']);
    }

    /**
     * Gets query for [[Task]].
     *
     * @return \frontend\models\query\TaskQuery
     */
    public function getPerformerTasks()
    {
        return $this->hasMany(Task::class, ['performer_user_id' => 'id']);
    }

    /** @return int Кол-во Заданий Исполнителя */
    public function getCountPerformerTasks(): int
    {
        return (int) count($this->performerTasks);
    }

    /** @return int Кол-во Заданий заказчика */
    public function getCountCustomerTasks(): int
    {
        return (int) count($this->customerTasks);
    }

    /** @return string|null Profile phone if set */
    public function getPhone(): ?string
    {
        return $this->profile ? $this->profile->phone : null;
    }

    /** @return string|null Profile skype if set */
    public function getSkype(): ?string
    {
        return $this->profile ? $this->profile->skype : null;
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
     * День рождения
     * @return string|null $birthDate В строковом формате
     */
    public function getBirthDate(): ?string
    {
        return $this->profile ? $this->profile->birth_date : null;
    }

    public function getBirthDateInterval(string $interval = 'y')
    {
        $now = new DateTime();
        $_intreval = $now->diff(new DateTime($this->getBirthDate()))->{$interval};

        return isset($_intreval) ? $_intreval : null;
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

    public function getFullName(): ?string
    {
        return trim($this->getLastName() . " " . $this->getFirstName());
    }

    public function getRatingAgregation()
    {
        return $this->getTaskResponses()
            ->select(['user_id', 'avgRating' => 'AVG(evaluation)'])
            // ->orderBy('avgRating DESC')
            ->groupBy(['user_id'])
            ->asArray(true);
    }

    public function getRating()
    {
        return $this->ratingAgregation[0]['avgRating'];
    }

    public function getIsPerformer(): bool
    {
        return $this->countPerformerTasks > 0 ? true : false;
    }

    /**
     * @return Query the active query used by this AR class.
     */
    public static function find(): Query
    {
        return new Query(get_called_class());
    }
}
