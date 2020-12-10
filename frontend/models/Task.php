<?php

namespace frontend\models;

use common\models\Tasks as BaseTask;
use frontend\models\query\TaskQuery as Query;
use frontend\models\query\TaskResponsesQuery;
use frontend\models\query\UserQuery;
use frontend\models\query\UserReviewQuery;

/**
 * @inheritDoc
 * 
 * @property-read TaskResponses[] $taskResponses
 * @property-read PerformerResponses[] $performerResponses
 * @property-read CustomerReviews[] $customerReviews
 * @property-read Categories[] $category
 */
class Task extends BaseTask
{
    /** @return array \DateTime array values */
    public function getInterval(): array
    {
        $now = new \DateTime();
        $created = new \DateTime($this->created_at);
        return (array) $now->diff($created);
    }

    public function getTaskResponses(): TaskResponsesQuery
    {
        return $this->hasMany(TaskResponses::class, ['task_id' => 'id']);
    }

    /**
     * @inheritDoc
     *
     * @return UserQuery
     */
    public function getCustomer(): UserQuery
    {
        return $this->hasOne(User::class, ['id' => 'customer_user_id']);
    }

    /** 
     * @inheritDoc
     * 
     * @return UserQuery
     */
    public function getPerformer(): UserQuery
    {
        return $this->hasOne(User::class, ['id' => 'performer_user_id']);
    }

    /**
     * @inheritDoc
     *
     * @return TaskResponsesQuery
     */
    public function getPerformerResponses(): TaskResponsesQuery
    {
        return $this->hasMany(TaskResponses::class, ['performer_user_id' => 'id'])
            ->via('performer');
    }

    /**
     * @inheritDoc
     *
     * @return UserReviewQuery
     */
    public function getCustomerReviews(): UserReviewQuery
    {
        return $this->hasMany(UserReview::class, ['customer_user_id' => 'id'])
            ->via('customer');
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
