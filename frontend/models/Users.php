<?php

namespace frontend\models;

use common\models\Users as ModelsUsers;
use frontend\models\query\UsersQuery as Query;

/** {@inheritDoc} */
class Users extends ModelsUsers
{
    public function getFullName()
    {
        return "{$this->last_name} {$this->first_name}";
    }

    public function getLastLogin()
    {
        $now = new \DateTime();
        $created = new \DateTime($this->last_logined_at);
        $diff = $now->diff($created);

        $gender = '{gender, select, male{Был} female{Была} other{Был}} на сайте';

        if ($diff->d > 0) {
            $old = '{n, plural, =0{# дней} =1{# день} one{# день} few{# дня} many{# дней} other{# дня}} назад';
            return \Yii::t('app', "{$gender} {$old}", ['n' => $diff->d, 'gender' => $this->gender]);
        } elseif ($diff->h > 0) {
            $old = '{n, plural, =1{# час} one{# час} few{# часа} many{# часов} other{# часов}} назад';
            return \Yii::t('app', "{$gender} {$old}", ['n' => $diff->h, 'gender' => $this->gender]);
        } elseif ($diff->i > 0) {
            $old = '{n, plural, =1{# минуту} one{# минуту} few{# минуты} many{# минут} other{# минут}} назад';
            return \Yii::t('app', "{$gender} {$old}", ['n' => $diff->i, 'gender' => $this->gender]);
        }
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
