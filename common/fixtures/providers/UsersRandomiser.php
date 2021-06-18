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
    public function randomCustomer(): \frontend\models\User
    {
        return $this->generator->randomElement($this->getCustomers());
    }

    /** @return \frontend\models\User|null ИД Исполнителя */
    public function randomPerformer(?int $skillId = null): ?\frontend\models\User
    {
        $performers = $this->getPerformers();

        if (\is_null($skillId)) {
            return $this->generator->randomElement($performers);
        }

        $_perfomers = null;

        foreach ($performers as $performer) {
            foreach ($performer->userCategories as $skill) {
                if ($skill->id === $skillId) {
                    $_perfomers[] = $performer;
                }
            }
        }

        return \is_null($_perfomers) ? null : $this->generator->randomElement($_perfomers);
    }


    private function getUsersQuery(): \frontend\models\query\UserQuery
    {
        return \frontend\models\User::find()
            ->with('userCategories');
    }

    /** @return \frontend\models\User[]|null Заказчики */
    private function getCustomers(): ?array
    {
        if (!$this->_customers) {
            foreach ($this->getUsersQuery()->all() as $user) {
                /** @var \frontend\models\User $user */
                if ($user && $user->isCustomer) {
                    $this->_customers[] = $user;
                }
            }
        }

        return $this->_customers;
    }

    /** @return \frontend\models\User[]|null Исполнители */
    private function getPerformers(): ?array
    {
        if (!$this->_performers) {
            foreach ($this->getUsersQuery()->all() as $user) {
                /** @var \frontend\models\User $user */
                if ($user && $user->isPerformer) {
                    // echo $user->id . "\n";
                    $this->_performers[] = $user;
                }
            }
        }
        return $this->_performers;
    }
}
