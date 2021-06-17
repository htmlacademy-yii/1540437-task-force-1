<?php

namespace common\fixtures\providers;

use Faker\Provider\Base;

class UsersRandomiser extends Base
{
    /** @var \frontend\models\User[] $_customers */
    private $_customers;
    /** @var \frontend\models\User[] $_performers */
    private $_performers;



    public function getFreePerformer(?string $skill = null)
    {

        $query = \frontend\models\User::find();
        $query->joinWith([
            'customerTasks ct' => function ($query) {
                /** @var \yii\db\ActiveQuery $query */
                return $query->andOnCondition(['ct.performer_user_id' => null]);
            },
            'userCategories uc' => function ($query) use ($skill) {
                /** @var \yii\db\ActiveQuery $query */
                if ($skill) {
                    $query->andOnCondition(['uc.category_id' => $skill]);
                }
                return $query;
            }
        ]);

        return $this->generator->randomElement($query->all());
    }

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
        if (!$this->_customers) {
            $this->_customers = \frontend\models\User::find()
                ->select('users.id')
                ->addSelect(['countUserCategory' => 'COUNT(uc.id)'])
                ->joinWith('userCategories uc')
                ->having(['=', 'countUserCategory', 0])
                ->groupBy('users.id')
                ->asArray()
                ->all();
        }

        return $this->_customers;
    }

    /** @return array|null Исполнители */
    private function getPerformers(): ?array
    {
        if (!$this->_performers) {
            $this->_performers = \frontend\models\User::find()
                ->select('users.id')
                ->addSelect(['countUserCategory' => 'COUNT(uc.id)'])
                ->joinWith('userCategories uc')
                ->having(['>', 'countUserCategory', 0])
                ->groupBy('users.id')
                ->asArray()
                ->all();
        }
        return $this->_performers;
    }
}
