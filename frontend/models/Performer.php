<?php

namespace frontend\models;

use frontend\models\query\CategoryQuery;
use frontend\models\query\PerformerQuery;
use frontend\models\query\TaskQuery;
use frontend\models\query\TaskResponseQuery;
use frontend\models\query\UserReviewQuery;
use Yii;
use yii\db\ActiveQuery;

/**
 * This is the model class for table "users".
 *
 * @property Task[] $tasks Мои задания
 * @property UserReview[] $reviews Отзывы пользователей
 * @property TaskResponse $responses Я откликнулся
 * @property Category[] $categories
 * @property-read bool $isOnline `true `Если последняя активыность была менее 30 минут
 */
class Performer extends User
{
    public $avgRating;
    public $countTasks;
    public $countReviews;

    public function getTaskCustomer()
    {
        return $this->getTasks()->with('customers');
    }

    /**
     * Gets query for [[UserFavorites]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUserFavorites()
    {
        return $this->hasMany(UserFavorite::class, ['favorite_user_id' => 'id']);
    }

    /**
     * Задания
     * 
     * @return TaskQuery 
     */
    public function getTasks(): TaskQuery
    {
        return $this->hasMany(Task::class, ['performer_user_id' => 'id'])->inverseOf('performer');
    }

    public function getTaskReviews()
    {
        return $this->hasMany(UserReview::class, ['related_task_id' => 'id'])->via('tasks');
    }

    /** @return TaskResponseQuery */
    public function getResponses(): TaskResponseQuery
    {
        return $this->hasMany(TaskResponse::class, ['performer_user_id' => 'id']);
    }

    /**
     * Query class for table [[categories]]
     *
     * @return CategoryQuery
     */
    public function getCategories(): CategoryQuery
    {
        return $this->hasMany(Category::class, ['id' => 'category_id'])
            ->via('userCategories');
    }

    /** @return ActiveQuery */
    public function getUserCategories(): ActiveQuery
    {
        return $this->hasMany(UserCategory::class,  ['user_id' => 'id']);
    }

    /**
     * Gets query for [[UserNotifications]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUserNotifications()
    {
        return $this->hasMany(UserNotification::class, ['user_id' => 'id']);
    }


    /** @return bool */
    public function getIsOnline(): bool
    {
        if ($this->isNewRecord) {
            return false;
        }

        $start = new \DateTime($this->last_logined_at);
        $end = new \DateTime('now');

        return $end->diff($start)->i > 30;
    }

    /**
     * User query class
     *
     * @return PerformerQuery
     */
    public static function find(): PerformerQuery
    {
        return new PerformerQuery(get_called_class());
    }
}
