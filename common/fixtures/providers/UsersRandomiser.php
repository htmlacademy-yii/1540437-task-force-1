<?php

namespace common\fixtures\providers;

use Faker\Provider\Base;

class UsersRandomiser extends Base
{
    /** @var array */
    private $customers;
    /** @var array */
    private $repformers;

    /** @return int|null ИД Заказчика */
    public function randomCustomer(): ?int
    {
        $result = $this->generator->randomElement($this->getCustomers());
        return $result ? $result['id'] : null;
    }

    /** @return int|null ИД Исполнителя */
    public function randomPerformer(bool $allowNull = false): ?int
    {
        $generator = $this->generator;
        if ($allowNull) {
            $generator = $this->generator->optional(0.8, null);
        }
        $result = $generator->randomElement($this->getPerformers());

        return $result ? $result['id'] : null;
    }

    /** @return array|null Заказчики */
    private function getCustomers(): ?array
    {
        if (!$this->customers) {
            $this->customers = \frontend\models\Users::find()
                ->select('id')
                ->customers()
                ->asArray()
                ->all();
        }

        return $this->customers;
    }

    /** @return array|null Исполнители */
    private function getPerformers(): ?array
    {
        if (!$this->repformers) {
            $this->repformers = \frontend\models\Users::find()
                ->select('id')
                ->performers()
                ->asArray()
                ->all();
        }
        return $this->repformers;
    }
}
