<?php

namespace frontend\models;

use frontend\models\query\CategoryQuery;
use frontend\models\query\CityQuery;
use frontend\models\query\TaskQuery;
use frontend\models\query\TaskResponseQuery;
use frontend\models\query\UserQuery;
use frontend\models\query\UserReviewQuery;

/**
 * This is the model class for table "tasks".
 * 
 * @property TaskChat[] $chats Чаты
 * @property TaskResponse[] $responses Отклики на задания
 * @property Category $category
 * @property User $customer Заказчик
 * @property User $performer Исполнитель
 * @property UserReview[] $userReviews Оценки пользователей
 */
class Task extends \common\models\Task
{

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        $rules = parent::rules();
        return $rules;
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        $labels = parent::attributeLabels();
        return $labels;
    }

    public function getCity()
    {
        return null;
    }

    /** @return TaskResponseQuery */
    public function getResponses(): TaskResponseQuery
    {
        return $this->hasMany(TaskResponse::class, ['task_id' => 'id']);
    }

    /** @return CategoryQuery */
    public function getCategory(): CategoryQuery
    {
        return $this->hasOne(Category::class, ['id' => 'category_id']);
    }

    /** @return UserQuery */
    public function getCustomer(): UserQuery
    {
        return $this->hasOne(User::class, ['id' => 'customer_user_id']);
    }

    /** @return UserQuery */
    public function getPerformer(): UserQuery
    {
        return $this->hasOne(User::class, ['id' => 'performer_user_id']);
    }

    /** @return UserReviewQuery Query for [[user_reviews]] */
    public function getUserReviews(): UserReviewQuery
    {
        return $this->hasMany(UserReview::class, ['task_id' => 'id']);
    }

    /** @return TaskQuery */
    public static function find(): TaskQuery
    {
        return new TaskQuery(get_called_class());
    }
}
