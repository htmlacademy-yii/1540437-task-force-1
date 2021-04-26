<?php

/**
 * Базоый класс Бизнеслогики Заданий
 *
 * @author Alexey Pozhidaev <worka@bk.ru>
 * @link   https://github.com/AlexBad
 */

namespace app\bizzlogic;

use app\actions\task\AbstractTaskAction;
use app\actions\task\Cancel as ActionCancel;
use app\actions\task\Complete as ActionComplete;
use app\actions\task\Pending as ActionPending;
use app\actions\task\Refuse as ActionRefuse;
use app\exceptions\task\NotAllowedStatusException;
use app\exceptions\task\NotFoundActionException;

class Task
{
    /** Задание опубликовано, исполнитель ещё не найден */
    const STATUS_NEW = 'NEW';
    /** Заказчик отменил задание */
    const STATUS_CANCELED = 'CANCELED';
    /** Заказчик выбрал исполнителя для задания */
    const STATUS_INPROGRESS = 'INPROGRESS';
    /** Заказчик отметил задание как выполненное */
    const STATUS_COMPLETE = 'COMPLETE';
    /** Исполнитель отказался от выполнения задания */
    const STATUS_FAIL = 'FAIL';

    private $customerId;
    private $performerId;
    private $status;

    /**
     * Создание новой схемы 'Задачи'.
     *
     * @param int $customer ID Заказчика
     * @param int|null $performer ID Исполнителя, по умолчанию NULL
     * @return void
     */
    public function __construct(int $customer, ?int $performer = null)
    {
        $this->status = self::STATUS_NEW;
        $this->customerId = $customer;
        $this->performerId = $performer;
    }

    /**
     * @param AbstractTaskAction $actionInternalName Внутренее имя Объекта действия
     * @return string Новый статус
     * @throws NotFoundActionException Если Запрашиваемое действие не описано
     */
    public function getNextStatus(AbstractTaskAction $action): string
    {
        $map = [
            ActionPending::internalName() => self::STATUS_INPROGRESS,
            ActionRefuse::internalName() => self::STATUS_FAIL,
            ActionCancel::internalName() => self::STATUS_CANCELED,
            ActionComplete::internalName() => self::STATUS_COMPLETE
        ];


        if (!isset($map[$action::internalName()])) {
            
            throw new NotFoundActionException($action::internalName());
        }

        return $map[$action::internalName()];
    }

    /**
     * Заказчик отменил задание
     *
     * @param int $usrId Ид пользователя
     * @return bool
     */
    public function cancel(int $userId): bool
    {
        $action = new ActionCancel;
        $nextStatus = $this->getNextStatus($action);

        if (
            $this->isStatusAllowed($nextStatus) &&
            $action->can($this->performerId, $this->customerId, $userId)
        ) {
            $this->changeStatus($nextStatus);
            return true;
        }

        return false;
    }
    

    /**
     * Исполнитель отказался от выполнения задания.
     *
     * @param int $userId
     * @return bool
     */
    public function refuse(int $userId): bool
    {
        $action = new ActionRefuse;
        $nextStatus = $this->getNextStatus($action);

        if (
            $this->isStatusAllowed($nextStatus) &&
            $action->can($this->performerId, $this->customerId, $userId)
        ) {
            $this->changeStatus($nextStatus);
            return true;
        }

        return false;
    }

    /**
     * Заказчик пометил задание как `Завершенное`.
     *
     * @param int $userId
     * @return bool
     */
    public function complete(int $userId): bool
    {
        $action = new ActionComplete;
        $nextStatus = $this->getNextStatus($action);

        if (
            $this->isStatusAllowed($nextStatus) &&
            $action->can($this->performerId, $this->customerId, $userId)
        ) {
            $this->changeStatus($nextStatus);
            return true;
        }

        return false;
    }

    /**
     * Исполнитель предложил свои услуги.
     *
     * @param int $userId
     * @return bool
     */
    public function pending(int $userId): bool
    {
        $action = new ActionPending;

        $nextStatus = $this->getNextStatus($action);

        if (
            $this->isStatusAllowed($nextStatus) &&
            $action->can($this->performerId, $this->customerId, $userId)
        ) {
            $this->changeStatus($nextStatus);
            return true;
        }

        return false;
    }

    /**
     * Возвращает текщуее `Состояние`
     *
     * @return string $status
     */
    public function getStatus(): string
    {
        return $this->status;
    }

    /** @return int $customerId */
    public function getCustomer(): int
    {
        return $this->customerId;
    }

    /** @return int|null $perfomerId */
    public function getPerformer(): ?int
    {
        return $this->performerId;
    }

    /**
     * Логика изменения статутса
     *
     * @param string $status Новый Статутс
     * @return void
     * @throws NotAllowedStatusException Если нельзя изменить "Статус"

     */
    private function changeStatus(string $status): void
    {
        $this->status = $status;
    }

    /**
     * @param string|null $newStatus
     * @return bool
     */
    private function isStatusAllowed(?string $newStatus): bool
    {
        return in_array($newStatus, self::statusMap($this->status));
    }

    /**
     * Вовзращает карту Статусов в зависимости
     * от запрашиваемого статуса.
     *
     * @param string $status
     * @return array
     */
    private static function statusMap(string $status): array
    {
        $map = [
            self::STATUS_NEW => [
                self::STATUS_CANCELED,
                self::STATUS_INPROGRESS
            ],
            self::STATUS_INPROGRESS => [
                self::STATUS_COMPLETE,
                self::STATUS_FAIL
            ]
        ];

        return isset($map[$status]) ? $map[$status] : [];
    }
}
