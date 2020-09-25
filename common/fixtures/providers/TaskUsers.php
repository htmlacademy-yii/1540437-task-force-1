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
    public function randomPerformer(): ?int
    {
        if (!$this->repformers) {
            $command = \Yii::$app->db->createCommand($this->command);
            $this->repformers = $command->bindValue(':roles', \app\bizzlogic\User::ROLE_PERFORMER)->queryAll();
        }
        return $this->repformers ? random_int(1, count($this->repformers)) : null;
    }

    /**
     * @param int $categoryId
     * @param int $maxIterations
     * @return array */
    public function randomPerformers(int $categoryId, int $maxIterations = 50): array
    {

        $iterations = random_int(1, $maxIterations);
        $res = [];

        while ($iterations > 0) {
            $data[] = random_int(1, count($this->getPerformers()));
            $iterations--;
        }

        $uniqUsers = array_values(array_unique($data, SORT_NUMERIC));

        foreach ($uniqUsers as $user) {
            $res['category_id'] = $categoryId;
            $res['user_id'] = $user;
        }

        return $res;
    }

    private function getCustomers(): array
    {
        if (!$this->customers) {
            $command = \Yii::$app->db->createCommand($this->command);
            $this->customers = $command->bindValue(':roles', \app\bizzlogic\User::ROLE_CUSTOMER)->queryAll();
        }

        return $this->customers;
    }

    private function getPerformers(): array
    {
        if (!$this->repformers) {
            $command = \Yii::$app->db->createCommand($this->command);
            $this->repformers = $command->bindValue(':roles', \app\bizzlogic\User::ROLE_PERFORMER)->queryAll();
        }
        return $this->repformers;
    }
}
