<?php

namespace common\fixtures\providers;

use Faker\Provider\Base;

class UsersRandomiser extends Base
{
    /** @var array */
    private $customers;
    /** @var array */
    private $repformers;
    /** @var \frontend\models\User[] $_customers */
    private $_customers;
    /** @var \frontend\models\User[] $_performers */
    private $_performers;

    /** @return \frontend\models\User Заказчик */
    public function getCustomer()
    {
        return $this->generator->randomElement(\frontend\models\User::find()->all());
    }

    /**
     * Исполнитель
     *
     * @param string|null $skill ID навыка, необходимого для задания
     * @return void
     */
    public function getPerformer(?string $skill = null)
    {
        if(!$this->_performers) {
            $query = \frontend\models\User::find();
            // $query->addSelect(['countSkills' => 'count(`uc`.`id`)']);
            $query->joinWith(['userCategories uc' => function($query) use ($skill) {
                /** @var \yii\db\ActiveQuery $query */
                if ($skill) {
                    $query->onCondition(['category_id' => $skill]);
                }
                return $query;
            }]);
            $this->_performers = $query->all();
        }

        return $this->generator->randomElement($this->_performers);
    }

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
        if (!$this->customers) {
            $this->customers = \frontend\models\User::find()
                ->select('users.id')
                ->addSelect(['countUserCategory' => 'COUNT(uc.id)'])
                ->joinWith('userCategories uc')
                ->having(['=', 'countUserCategory', 0])
                ->groupBy('users.id')
                ->asArray()
                ->all();
        }

        return $this->customers;
    }

    /** @return array|null Исполнители */
    private function getPerformers(): ?array
    {
        if (!$this->repformers) {
            $this->repformers = \frontend\models\User::find()
                ->select('users.id')
                ->addSelect(['countUserCategory' => 'COUNT(uc.id)'])
                ->joinWith('userCategories uc')
                ->having(['>', 'countUserCategory', 0])
                ->groupBy('users.id')
                ->asArray()
                ->all();
        }
        return $this->repformers;
    }
}
