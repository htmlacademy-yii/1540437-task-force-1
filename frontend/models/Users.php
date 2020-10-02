<?php

namespace frontend\models;

use common\models\Users as ModelsUsers;
use frontend\models\query\UsersQuery as Query;

/**
 * {@inheritDoc}
 *
 * @property \frontend\models\query\CategoriesQuery[] $categories
 * @property \frontend\models\query\TasksQuery[] $performerTasks
 * @property \frontend\models\query\TasksQuery[] $customersTasks
 * @property \common\models\aq\TaskResponsesQuery[] $taskResponsesAggregation
 * @property string $fullName
 * @property string|null $iconByGender
 * @property float $avgEvaluation
 * @property int $countResponses
 * @property int $countPerformerTasks
 * @property int $countCustomerTasks
 */
class Users extends ModelsUsers
{
    /** @return string|null Наименование иконки */
    public function getIconByGender(): ?string
    {
        switch ($this->gender) {
            case \app\bizzlogic\User::GENDER_MALE:
                return 'man';
                break;
            case \app\bizzlogic\User::GENDER_FEMALE:
                return 'woman';
                break;
            default:
                return null;
                break;
        }
    }

    /** @return string Concat lastname & firstname */
    public function getFullName(): string
    {
        return "{$this->last_name} {$this->first_name}";
    }

    /** @return array DateInterval values */
    public function getLastLogin(): array
    {
        $now = new \DateTime();
        $created = new \DateTime($this->last_logined_at);
        $interval = $now->diff($created);

        return (array) $interval;
    }

    /** @return float `(float) Yii::$app->formatter->asDecimal()` */
    public function getAvgEvaluation(): float
    {
        return (float) $this->taskResponsesAggregation ? \Yii::$app->formatter->asDecimal($this->taskResponsesAggregation[0]['avg'], 2) : 0;
    }

    /** @return int Кол-во откликов */
    public function getCountResponses(): int
    {
        return (int) $this->taskResponsesAggregation ? $this->taskResponsesAggregation[0]['count'] : 0;
    }

    /**
     * Аггрегация данных TaskResponses.
     *
     * `avg` Средняя оценка пользователя,
     * `count` Кол-во Задач текущего пользвателя.
     *
     * @return \yii\db\ActiveQuery
     */
    public function getTaskResponsesAggregation(): \yii\db\ActiveQuery
    {
        return $this->getTaskResponses()
            ->select(['user_id',  'avg' => 'avg(evaluation)', 'count' => 'count(*)'])
            ->groupBy(['user_id'])
            ->asArray(true);
    }

    /**
     * Gets query for [[Categories]].
     *
     * @return \frontend\models\query\CategoriesQuery
     */
    public function getCategories(): \frontend\models\query\CategoriesQuery
    {
        return $this->hasMany(Categories::class, ['id' => 'category_id'])
            ->via('userCategories');
    }

    /**
     * Gets query for [[Tasks]].
     *
     * @return \frontend\models\query\TasksQuery
     */
    public function getPerformerTasks(): \frontend\models\query\TasksQuery
    {
        return $this->hasMany(Tasks::class, ['performer_user_id' => 'id']);
    }

    /**
     * Gets query for [[Tasks]].
     *
     * @return \frontend\models\query\TasksQuery
     */
    public function getCustomerTasks(): \frontend\models\query\TasksQuery
    {
        return $this->hasMany(Tasks::class, ['customer_user_id' => 'id']);
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
