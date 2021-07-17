<?php

namespace frontend\models;

use frontend\models\query\CustomerQuery;
use frontend\models\query\PerformerQuery;
use frontend\models\query\TaskQuery;
use frontend\models\query\UserQuery;
use frontend\models\query\UserReviewQuery;

/**
 * {@inheritDoc}
 * @property Task $task
 * @property User $user Заказчик
 */
class UserReview extends \common\models\UserReview
{
    public $avgReating;


    /**
     * Gets query for [[Task]].
     *
     * @return TaskQuery
     */
    public function getTask(): TaskQuery
    {
        return $this->hasOne(Task::class, ['id' => 'related_task_id'])->inverseOf('userReviews');
    }

    public function getCustomer(): CustomerQuery
    {
        return $this->hasOne(Customer::class, ['id' => 'user_id'])->inverseOf('reviews');
    }

    public function getPerformer(): PerformerQuery
    {
        return $this->hasOne(Performer::class, ['id' => 'performer_user_id'])
            ->via('task');
    }


    public static function find(): UserReviewQuery
    {
        return new UserReviewQuery(get_called_class());
    }
}
