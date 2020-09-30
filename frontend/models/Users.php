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
 */
class Users extends ModelsUsers
{
    /** @return string|null Наименование иконки */
    public function getIconByGender(): ?string
    {
        if (!$this->gender) {
            return null;
        }

        switch ($this->gender) {
            case 'male':
                return 'man';
                break;
            case 'female':
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

    /** @return string Последний логин, в виде строки */
    public function getLastLogin(): string
    {
        $now = new \DateTime();
        $created = new \DateTime($this->last_logined_at);
        $diff = $now->diff($created);

        $gender = '{gender, select, male{Был} female{Была} other{Было}} на сайте';

        if ($diff->d > 0) {
            $old = '{n, plural, =0{# дней} =1{# день} one{# день} few{# дня} other{# дней}} назад';
            return \Yii::t('app', "{$gender} {$old}", ['n' => (int) $diff->d, 'gender' => $this->gender]);
        } elseif ($diff->h > 0) {
            $old = '{n, plural, =1{# час} one{# час} few{# часа} many{# часов} other{# часов}} назад';
            return \Yii::t('app', "{$gender} {$old}", ['n' => (int) $diff->h, 'gender' => $this->gender]);
        } elseif ($diff->i > 0) {
            $old = '{n, plural, =1{# минуту} one{# минуту} few{# минуты} many{# минут} other{# минут}} назад';
            return \Yii::t('app', "{$gender} {$old}", ['n' => (int) $diff->i, 'gender' => $this->gender]);
        }
    }

    /**
      * Gets query for [[Categories]].
      *
      * @return \frontend\models\query\CategoriesQuery[]
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
    public function getPerformerTasksCount(): int
    {
        return (int) count($this->performerTasks);
    }

    /** @return int|string Кол-во Заданий заказчика */
    public function getCustomerTasksCount(): int
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
