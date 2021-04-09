<?php

namespace frontend\models\query;

/** {@inheritDoc} */
class TaskResponseQuery extends \yii\db\ActiveQuery
{
    /** Успешно выполненно */
    public function success(bool $success = true)
    {
        return $this->andWhere(['is_success' => $success]);
    }
}
