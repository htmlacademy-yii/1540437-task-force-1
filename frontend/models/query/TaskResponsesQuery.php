<?php

namespace frontend\models\query;

/** {@inheritDoc} */
class TaskResponsesQuery extends \yii\db\ActiveQuery
{
    /** Успешно выполненно */
    public function success()
    {
        return $this->andWhere(['is_success' => true]);
    }
}
