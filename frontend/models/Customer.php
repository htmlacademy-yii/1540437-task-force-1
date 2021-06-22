<?php

namespace frontend\models;

use frontend\models\query\CustomerQuery;

class Customer extends User
{
    public function getReviews()
    {
        return $this->hasMany(UserReview::class, ['user_id' => 'id'])->inverseOf('customer');
    }

    public static function find(): CustomerQuery
    {
        return new CustomerQuery(\get_called_class());
    }
}
