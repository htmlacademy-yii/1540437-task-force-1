<?php

namespace common\fixtures\providers;

use Faker\Provider\Base;

class TaskUsers extends Base
{
    private $command = 'SELECT `id` from `users` WHERE `role`=:roles';
    private $customers;
    private $repformers;

    /** @return int|null ИД Заказчика */
    public function randomCustomer(): ?int
    {
        if (!$this->customers) {
            $command = \Yii::$app->db->createCommand($this->command);
            $this->customers = $command->bindValue(':roles', \app\bizzlogic\User::ROLE_CUSTOMER)->queryAll();
        }
        return $this->customers ? random_int(1, count($this->customers)) : null;
    }

    /** @return int|null ИД Исполнителя */
    public function randomPerformer()
    {
        if (!$this->customers) {
            $command = \Yii::$app->db->createCommand($this->command);
            $this->repformers = $command->bindValue(':roles', \app\bizzlogic\User::ROLE_PERFORMER)->queryAll();
        }
        return $this->repformers ? random_int(1, count($this->repformers)) : null;
    }
}
