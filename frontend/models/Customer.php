<?php

namespace frontend\models;

use frontend\models\query\CustomerQuery;

/**
 * 
 * @property int $countTasks
 */
class Customer extends User
{
    private $_counTasks;

    public function getCountTasks()
    {
        if (!$this->_counTasks) {
            $this->_counTasks = $this->getTasks()->count();
        }

        return (int) $this->_counTasks;
    }

    public function setCountTasks(string $value)
    {
        $this->_counTasks = $value;
    }

    public function getTasks()
    {
        return $this->hasMany(Task::class, ['user_id' => 'id'])->inverseOf('customer');
    }

    public function getReviews()
    {
        return $this->hasMany(UserReview::class, ['user_id' => 'id'])->inverseOf('customer');
    }

    public static function find(): CustomerQuery
    {
        return new CustomerQuery(\get_called_class());
    }
}
