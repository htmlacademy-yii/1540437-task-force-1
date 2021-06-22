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
 * @property Category[] $skill
 * @property-read bool $isOnline `true `Если последняя активыность была менее 30 минут
 */
class Performer extends User
{
    // public $avgRating;
    // public $countTasks;
    // public $countReviews;

    private $_avgRating;
    private $_countReviews;
    private $_countTasks;

    public function setAvgRating(?string $value)
    {
        if ($value !== null) {
            $this->_avgRating = $value;
        }
    }

    public function getAvgRating()
    {
        if (!$this->_avgRating) {
            $this->_avgRating = $this->totalReviewsAggregation ? $this->totalReviewsAggregation[0]['avgRating'] : 0;
        }

        return $this->_avgRating;
    }

    public function getCountReviews()
    {
        if (!$this->_countReviews) {
            $this->_countReviews = $this->totalReviewsAggregation ? $this->totalReviewsAggregation[0]['countReviews'] : 0;
        }

        return $this->_countReviews;
    }

    public function setCountReviews(?string $value)
    {
        if ($value === null) {
            $value = 0;
        }
        $this->_countReviews = $value;
    }

    public function setCountTasks(?string $value)
    {
        if ($value === null) {
            $value = 0;
        }

        $this->_countTasks = $value;
    }

    public function getCountTasks()
    {
        return $this->_countTasks;
    }

    public function getCountCompletedTasks()
    {
        if (!$this->_countTasks) {
            $this->_countTasks = $this->getCompletedTasks()->count();
        }

        return $this->_countTasks;
    }

    public function getTotalReviewsAggregation()
    {
        return $this->getTaskReviews()
            ->select([
                'avgRating' => 'avg(`user_reviews`.rate)',
                'countReviews' => 'count(`user_reviews`.`id`)',
            ])
            ->asArray(true);
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

    public function getCompletedTasks()
    {
        return $this->hasMany(Task::class, ['performer_user_id' => 'id'])->done();
    }

    /**
     * Задания
     * 
     * @return TaskQuery 
     */
    public function getTasks(): TaskQuery
    {
        return $this->hasMany(Task::class, ['performer_user_id' => 'id']);
    }

    public function getTaskReviews(): UserReviewQuery
    {
        return $this->hasMany(UserReview::class, ['related_task_id' => 'id'])->via('completedTasks');
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
    public function getSkils(): CategoryQuery
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
