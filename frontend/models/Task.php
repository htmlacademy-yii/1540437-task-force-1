<?php

namespace frontend\models;

use common\models\Tasks as BaseTask;
use frontend\models\query\TaskQuery as Query;

/**
 * {@inheritDoc}
 * @property TaskResponses[] $taskResponse
 * @property Categories $category
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

    /**
     * {@inheritdoc}
     * @return Query the active query used by this AR class.
     */
    public static function find(): Query
    {
        return new Query(get_called_class());
    }
}
