<?php

namespace frontend\models;

use common\models\Tasks as ModelsTasks;
use frontend\models\query\TasksQuery as Query;

/** {@inheritDoc} */
class Tasks extends ModelsTasks
{
    /**
     * {@inheritdoc}
     * @return Query the active query used by this AR class.
     */
    public static function find(): Query
    {
        return new Query(get_called_class());
    }

    /** @return string Plural string, days|hours left */
    public function interval()
    {
        $now = new \DateTime();
        $created = new \DateTime($this->created_at);
        $diff = $now->diff($created);

        if ($diff->d > 0) {
            return \Yii::t('app', '{n, plural, one{# day} two{# days} other{# days}} ago', ['n' => $diff->d]);
        } else if ($diff->h > 0) {
            return \Yii::t('app', '{n, plural, one{# hour} two{# hours} other{# hours}} left', ['n' => $diff->h]);
        } else {
            return \Yii::t('app', '{n, plural, one{# minut} two{# minuts} other{# minuts}} left', ['n' => $diff->i]);
        }
    }
}
