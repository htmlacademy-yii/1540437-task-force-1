<?php

namespace frontend\models;

use common\models\UserReviews;
use frontend\models\query\UserReviewQuery;

class UserReview extends UserReviews
{
    /**
     * @inheritDoc
     *
     * @return UserReviewQuery
     */
    public static function find(): UserReviewQuery
    {
        return new UserReviewQuery(get_called_class());
    }
}
