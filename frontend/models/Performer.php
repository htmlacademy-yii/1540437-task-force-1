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
class Performer extends \common\models\User
{

    // public $avgRating;
    private $_avgRating;
    private $_countReviews;

    public function getAvgRating()
    {
        if ($this->isNewRecord) {
            return null;
        }

        if (!$this->_avgRating) {
            $this->_avgRating = isset($this->reviewsAggregation) ? $this->reviewsAggregation['avgRating'] : 0;
        }

        return $this->_avgRating;
    }

    public function getCountReviews()
    {
        if (!$this->_countReviews) {
            $this->_countReviews = isset($this->reviewsAggregation) ? $this->reviewsAggregation['countReviews'] : 0;
        }

        return $this->_countReviews;
    }

    public function getReviewsAggregation()
    {
        $userReviewsQuery = \frontend\models\UserReview::find()->where(['related_task_id' => $this->getTasks()->select('id') ]);
        $userReviewsQuery->select([
            'countReviews' => 'count(id)',
            'avgRating' => 'avg(rate)'
        ]);
        
        return $userReviewsQuery->asArray(true);

        // return $userReviewsQuery->all();

        // return $userReviewsQuery;

        // return $this->getReviews()
        //     ->select([
        //         'id',
        //         'avgRating' => 'AVG(`rate`)',
        //         'countReviews' => 'count(`id`)'
        //     ])
        //     ->groupBy(['id'])
        //     ->asArray(true);
    }

    public function getTaskCustomer()
    {
        return $this->getTasks()->with('customers');
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

    /**
     * Отзывы пользователей
     * 
     * @return UserReviewQuery 
     */
    public function getReviews(): UserReviewQuery
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

    /**
     * Gets query for [[City]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCity()
    {
        return $this->hasOne(City::class, ['id' => 'city_id']);
    }

    /**
     * Gets query for [[Profile]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getProfile(): \yii\db\ActiveQuery
    {
        return $this->hasOne(UserProfile::class, ['id' => 'profile_id']);
    }

    /**
     * Является ли пользователь Заказчиком
     * 
     * @return bool
     */
    public function getIsCustomer(): bool
    {
        return empty($this->userCategories);
    }

    /**
     * Является ли пользователь Исполнителем
     *
     * @return bool
     */
    public function getIsPerformer(): bool
    {
        return count($this->userCategories) > 0;
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
     * @return string|null Дата последного входа в систему
     */
    public function getLastLogin(): ?string
    {
        return $this->last_logined_at;
    }

    public function setPassword(string $value)
    {
        $this->password = Yii::$app->getSecurity()->generatePasswordHash($value);
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
