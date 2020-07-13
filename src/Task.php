<?php

/**
 * Базовый класс Задач
 * 
 * @property int $performerId ID Исполнителя 
 * @property int $customerId ID Заказчика
 * @property string $status Статус задачи
 */
class Task
{
    /** Задание опубликовано, исполнитель ещё не найден */
    const STATUS_NEW = 'new';
    /** Заказчик отменил задание */
    const STATUS_CANCELED = 'canceled';
    /** Заказчик выбрал исполнителя для задания */
    const STATUS_INPROGRESS = 'in_progress';
    /** Заказчик отметил задание как выполненное */
    const STATUS_COMPLETE = 'complete';
    /** Исполнитель отказался от выполнения задания */
    const STATUS_FAIL = 'fail';

    /** Заказчик отменил задание */
    const ACTION_CUSTOMER_CANCEL = 'cancel';
    /** Заказчик пометил задание как Завершенное */
    const ACTION_CUSTOMER_COMPLETE = 'complete';
    /** Исполнитель откликнулся на новое задание */
    const ACTION_PERFORMER_PENDING = 'pending';
    /** Исполнитель отказался от задания */
    const ACTION_PERFORMER_REFUSE = 'refuse';

    /**
     * Список состояний 'Задания'
     * @var array 
     */
    const STATUS_LIST = [
        self::STATUS_NEW,
        self::STATUS_CANCELED,
        self::STATUS_COMPLETE,
        self::STATUS_FAIL,
        self::STATUS_INPROGRESS
    ];

    /** 
     * Список действий 'Задания'
     * @var array
     */
    const ACTION_LIST = [
        self::ACTION_CUSTOMER_CANCEL,
        self::ACTION_CUSTOMER_COMPLETE,
        self::ACTION_PERFORMER_PENDING,
        self::ACTION_PERFORMER_REFUSE
    ];

    protected $customerId;
    protected $performerId;
    protected $status;

    /**
     * Создание новой схемы 'Задачи'.
     * 
     * @param int $customer ID Заказчика
     * @param int|null $performer ID Исполнителя, по умолчанию NULL
     * @return void
     */
    public function __construct(int $customer, ?int $performer = null)
    {
        if (!isset($this->status)) {
            $this->status = self::STATUS_NEW;
        }
        $this->customerId = $customer;
        $this->performerId = $performer;
    }

    /**
     * Заказчик отменил задание
     * @return string $status
     */
    public function actionCancel(): string
    {
        $this->changeStatus(self::STATUS_CANCELED, self::ACTION_CUSTOMER_CANCEL);
        return $this->status;
    }

    /**
     * Исполнитель отказался от выполнения задания.
     * @return string $status
     */
    public function actionRefuse(): string
    {
        $this->changeStatus(self::STATUS_FAIL, self::ACTION_PERFORMER_REFUSE);
        return $this->status;
    }

    /**
     * Заказчик пометил задание как `Завершенное`
     * @return string $status
     */
    public function actionComplete(): string
    {
        $this->changeStatus(self::STATUS_COMPLETE, self::ACTION_CUSTOMER_COMPLETE);
        return $this->status;
    }

    /**
     * Исполнитель предложил свои услуги
     * @return string $status
     */
    public function actionPending(): string
    {
        $this->changeStatus(self::STATUS_INPROGRESS, self::ACTION_PERFORMER_PENDING);
        return $this->status;
    }

    /**
     * Возвращает текщуее `Состояние`
     * @return string $status
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Устанавливает `Состояние` для приложения
     *
     * @param string $status
     * @throws NotValidStatusException Если `Состояние` является не допустимым значением
     */
    private function setStatus(string $status): void
    {
        if (!self::isStatusValid($status)) {
            throw new NotValidStatusException($status);
        }

        $this->status = $status;
    }

    /** @return int $customerId */
    public function getCustomer()
    {
        return $this->customerId;
    }

    /** @return int|null $perfomerId */
    public function getPerformer()
    {
        return $this->performerId;
    }

    /**
     * Карта `Действий`
     *
     * @return array
     */
    private function getActionsMap(): array
    {

        $map = [
            self::STATUS_NEW => [
                self::ACTION_CUSTOMER_CANCEL
            ],
            self::STATUS_INPROGRESS => [
                self::ACTION_CUSTOMER_CANCEL,
                self::ACTION_CUSTOMER_COMPLETE,
            ]
        ];

        if ($this->isHasPerformer()) {
            $map[self::STATUS_NEW][] = self::ACTION_PERFORMER_PENDING;
            $map[self::STATUS_INPROGRESS][] = self::ACTION_PERFORMER_REFUSE;
        }

        return $map;
    }

    /**
     * Список доступных `Состояний` для перехода`.
     * 
     * 
     * @param string|null $status
     * @return array [ status => [ ...allowedStatusList ] ]
     */
    private function getStatusMap(?string $status = null): array
    {
        $map = [];
        $map[self::STATUS_NEW] = self::STATUS_CANCELED;

        if ($this->isHasPerformer()) {
            $map[self::STATUS_NEW][] = self::STATUS_INPROGRESS;
            $map[self::STATUS_INPROGRESS] = [
                self::ACTION_PERFORMER_REFUSE,
                self::STATUS_COMPLETE,
                self::STATUS_FAIL
            ];
        }

        if (is_null($status)) {
            return $map;
        } else {
            return isset($map[$status]) ? $map[$status] : [];
        }
    }

    /**
     * Возвращает список `Действий` текущего `Состояния`
     * 
     * @return array|null 
     */
    public function getActionsByCurrentStatus(): ?array
    {
        $status = $this->getStatus();
        $actions = $this->getActionsMap();

        return isset($actions[$status]) ? $actions[$status] : null;
    }



    /** 
     * Изменение статуса задания
     * 
     * @param string $status Новый статус.
     * @param string $action Текущее действие. 
     * @throws NotAllowedChangeStatusException Если `Новое состояние` не допускается к изменению.
     * @throws NotAllowedActionException Если не возможно выполнить `Действие`.
     * @return void    
     */
    public function changeStatus(string $status, string $action): void
    {
        $status = trim($status);
        if (!self::isStatusValid($status)) {
            throw new NotAllowedChangeStatusException("Состояние '{$status}' - не входит в список допустимых.");
        }

        if (!self::isActionValid($action)) {
            throw new NotAllowedActionException("Действие '{$action}' - не допустимо");
        }

        if (!$this->canChangeStatus($status)) {
            throw new NotAllowedChangeStatusException("Из состояния '{$this->status}' не возможно перейти в сосояние '{$status}'");
        }

        if (!$this->canRunAction($action)) {
            $message = "Не возможно выполнить действие: '{$action}'";
            if (is_null($this->performerId)) {
                $message .= " т.к. исполнитель не выбран";
            }
            throw new NotAllowedActionException($message);
        }

        $this->setStatus($status);
    }

    /** 
     * Проверяет, допускается ли изменение статуса
     * @param string $status
     * @return bool
     */
    protected function canChangeStatus(string $status): bool
    {
        $statusMap = $this->getStatusMap($status);
        return in_array($status, $statusMap[$status]);
    }

    /**
     * Проверяет, допускаетлся выполнение Действия
     *
     * @param string $action
     * @return bool
     */
    protected function canRunAction(string $action): bool
    {
        $actionChain = $this->getActionsByCurrentStatus();
        if (is_null($actionChain)) {
            return false;
        }

        return in_array($action, $actionChain[$this->getStatus()]);
    }

    /**
     * Проверяет соответсвие запрашиваемого статуса к списку возможных статусов.
     * 
     * @param string $status Именованный статус задания.
     * @return bool
     */
    private static function isStatusValid(string $status): bool
    {
        return in_array($status, self::STATUS_LIST);
    }

    /**
     * @param string $action Наименование 'Действия'
     * @return bool
     */
    private static function isActionValid(string $action): bool
    {
        return in_array($action, self::ACTION_LIST);
    }

    /**
     * Проверка на наличие `Исполнителя` в `Задании`.
     * @return bool
     */
    private function isHasPerformer(): bool
    {
        return !is_null($this->getPerformer());
    }
}


class BaseTaskException extends Exception
{
}

class StatusTaskException extends BaseTaskException
{
}

/** Status Exceptions */

class NotValidStatusException extends StatusTaskException
{
}

class NotFoundStatusException extends StatusTaskException
{
}

class NotAllowedStatusException extends StatusTaskException
{
}

/** Action Exception  */

class ActionTaskException extends BaseTaskException
{
}



class NotAllowedActionException extends Exception
{
}

class NotAllowedChangeStatusException extends Exception
{
}
