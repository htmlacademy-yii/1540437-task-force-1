<?php

/**
 * Базовый класс Задач
 * 
 * @property int $performerId ID Исполнителя 
 * @property int $customerId ID Заказчика
 * @property string $status Статус задачи
 * @property string $role Роль пользователя
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

    /** Исполнитель */
    const ROLE_PERFORMER = 'performer';
    /** Заказчик */
    const ROLE_CUSTOMER = 'customer';

    private $customerId;
    private $performerId;
    private $status;
    private $role;

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
     * @param string $action `Действие`
     * @return string|null Наименование Состояния
     */
    public function getNextStatus(string $action): ?string
    {
        $map = [
            self::ACTION_PERFORMER_PENDING => self::STATUS_INPROGRESS,
            self::ACTION_PERFORMER_REFUSE => self::STATUS_FAIL,
            self::ACTION_CUSTOMER_CANCEL => self::STATUS_CANCELED,
            self::ACTION_CUSTOMER_COMPLETE => self::STATUS_COMPLETE
        ];

        return isset($map[$action]) ? $map[$action] : null;
    }

    /**
     * Заказчик отменил задание
     * @return string $status
     */
    public function actionCancel(): string
    {
        $this->changeStatus(self::ACTION_CUSTOMER_CANCEL);
        return $this->getStatus();
    }

    /**
     * Исполнитель отказался от выполнения задания.
     * @return string $status
     */
    public function actionRefuse(): string
    {
        $this->changeStatus(self::ACTION_PERFORMER_REFUSE);
        return $this->getStatus();
    }

    /**
     * Заказчик пометил задание как `Завершенное`
     * @return string $status
     */
    public function actionComplete(): string
    {
        $this->changeStatus(self::ACTION_CUSTOMER_COMPLETE);
        return $this->getStatus();
    }

    /**
     * Исполнитель предложил свои услуги
     * @return string $status
     */
    public function actionPending(): string
    {
        $this->changeStatus(self::ACTION_PERFORMER_PENDING);
        return $this->getStatus();
    }

    /**
     * Возвращает текщуее `Состояние`
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

    /** @return string|null $role */
    public function getRole(): ?string
    {
        return $this->role;
    }

    /**
     * Представиться "Заказчиком"
     * @return self
     */
    public function asCustomer(): self
    {
        $this->setRole(self::ROLE_CUSTOMER);
        return $this;
    }

    /**
     * Представиться "Исполнителем"
     * @return self
     */
    public function asPerformer(): self
    {
        $this->setRole(self::ROLE_PERFORMER);
        return $this;
    }

    /**
     * Устанавливает новое "Состояние" для приложения
     * @param string $status
     */
    private function setStatus(string $status): void
    {
        $this->status = $status;
    }

    /**
     * Устанавливает "Роль"
     * @return void
     * @throws NotFoundRoleException Если "Роль" не найдена.
     */
    private function setRole(string $role): void
    {
        if (!self::isRoleValid($role)) {
            throw new NotFoundRoleException($role);
        }
        $this->role = $role;
    }

    /** 
     * Сбрасывает "Роль"
     */
    private function resetRole(): void
    {
        $this->role = null;
    }

    /** 
     * Изменяет "Состояние" после выполнения "Действия"
     * 
     * @param string $currentAction Текущее действие. 
     * @return void
     * @throws NotAllowedStatusException Если нельзя изменить "Статус"
     * @throws NotAllowedActionException Если нельзя выполнить "Действие"
     */
    private function changeStatus(string $currentAction): void
    {
        $newStatus = $this->getNextStatus($currentAction);

        if (!$this->canChangeStatus($newStatus)) {
            throw new NotAllowedStatusException($newStatus);
        }

        if (!$this->canRunAction($currentAction)) {
            throw new NotAllowedActionException($currentAction);
        }

        $this->setStatus($newStatus);
        $this->resetRole();
    }

    /**
     * Проверка на наличие `Исполнителя` в `Задании`.
     * @return bool
     */
    public function isHasPerformer(): bool
    {
        return !is_null($this->getPerformer());
    }

    /**
     * Возвращает "Действия" текущего пользователя на основе его "Роли"
     * 
     * @return array
     * @throws UndefinedRoleException Если "Роль" не определена.
     */
    private function getRoleActions(): array
    {
        $currentRole = $this->getRole();
        if (is_null($currentRole)) {
            throw new UndefinedRoleException();
        }

        $actions = self::listRoleActions();

        return isset($actions[$currentRole]) ? $actions[$currentRole] : [];
    }

    /**
     * Возвращает "Действия" текущего "Состояния"
     * @return array
     */
    private function getStatusActions(): array
    {
        $currentStatus = $this->getStatus();
        $actions = self::listStatusActions();

        return isset($actions[$currentStatus]) ? $actions[$currentStatus] : [];
    }

    /**
     * Список доступных "Действий" для "Состояния".
     * 
     * @param string $status
     * @return array
     */
    private function getAllowedActionsList(): array
    {
        $roleActions = $this->getRoleActions();
        $statusActions = $this->getStatusActions();

        return array_intersect($roleActions, $statusActions);
    }

    /** 
     * Список доступных "Состояний"
     * @return array
     */
    private function getAllowedStatusList(): array
    {
        $statusList = self::listStatusStatuses();
        $currentStatus = $this->getStatus();

        return isset($statusList[$currentStatus]) ? $statusList[$currentStatus] : [];
    }

    /** 
     * Проверяет, допускается ли изменение статуса
     * @param string $status
     * @return bool
     * @throws NotValidStatusException Если не корректное "Состояние"
     */
    protected function canChangeStatus(string $status): bool
    {
        if (!self::isStatusValid($status)) {
            throw new NotValidStatusException($status);
        }

        return in_array($status, $this->getAllowedStatusList());
    }

    /**
     * Проверяет, допускается ли выполнение "Действия"
     *
     * @param string $action Действие
     * @return bool
     * @throws NotValidActionException Если не корректное "Действие"
     */
    protected function canRunAction(string $action): bool
    {
        if (!self::isActionValid($action)) {
            throw new NotValidActionException($action);
        }

        return in_array($action, $this->getAllowedActionsList());
    }

    /**
     * @param string $status "Состояние".
     * @return bool
     */
    private static function isStatusValid(string $status): bool
    {
        return in_array($status, self::statusMap(true));
    }

    /**
     * @param string $action "Действие"
     * @return bool
     */
    private static function isActionValid(string $action): bool
    {
        return in_array($action, self::actionMap(true));
    }

    /**
     * @param string $role "Роль"
     * @return bool
     */
    private static function isRoleValid(string $role): bool
    {
        return in_array($role, self::roleMap(true));
    }

    /**
     * Список "Состояний" для каждого "Состояния".
     * 
     * @return array [ status => [...statuses] ]
     */
    private static function listStatusStatuses(): array
    {
        return [
            self::STATUS_NEW => [
                self::STATUS_CANCELED,
                self::STATUS_INPROGRESS
            ],
            self::STATUS_INPROGRESS => [
                self::STATUS_COMPLETE,
                self::STATUS_FAIL
            ]
        ];
    }

    /**
     * Список "Действий" для каждого "Состояния".
     * 
     * @return array [ status => [...actions]]
     */
    private static function listStatusActions(): array
    {
        return [
            self::STATUS_NEW => [
                self::ACTION_CUSTOMER_CANCEL,
                self::ACTION_PERFORMER_PENDING
            ],
            self::STATUS_INPROGRESS => [
                self::ACTION_CUSTOMER_CANCEL,
                self::ACTION_CUSTOMER_COMPLETE,
                self::ACTION_PERFORMER_REFUSE
            ]
        ];
    }

    /** 
     * Список "Действий" для каждой "Роли"
     * 
     * @return array [ role => [...actions]]
     */
    private static function listRoleActions(): array
    {
        return [
            self::ROLE_CUSTOMER => [
                self::ACTION_CUSTOMER_CANCEL,
                self::ACTION_CUSTOMER_COMPLETE
            ],
            self::ROLE_PERFORMER => [
                self::ACTION_PERFORMER_PENDING,
                self::ACTION_PERFORMER_REFUSE
            ]
        ];
    }

    /**
     * Карта всех действий.
     * 
     * @param bool $onlyKeys По умалчанию `false`
     * @return array Ассоциативный массив или только ключи
     */
    private static function actionMap(bool $onlyKeys = false): array
    {
        $map = [
            self::ACTION_CUSTOMER_CANCEL => 'Отменить',
            self::ACTION_CUSTOMER_COMPLETE => 'Завершить',
            self::ACTION_PERFORMER_PENDING => 'Откликнутся',
            self::ACTION_PERFORMER_REFUSE => 'Отказатся'
        ];

        return $onlyKeys ? array_keys($map) : $map;
    }

    /**
     * Карта всех статусов.
     * 
     * @param bool $onlyKeys По умолчанию `false`
     * @return array Ассоциативный массив или только ключи
     */
    private static function statusMap(bool $onlyKeys = false): array
    {
        $map =  [
            self::STATUS_NEW => 'Новое',
            self::STATUS_CANCELED => 'Отменено',
            self::STATUS_COMPLETE => 'Завершено',
            self::STATUS_FAIL => 'Провалено',
            self::STATUS_INPROGRESS => 'Выполняется'
        ];

        return  $onlyKeys ? array_keys($map) : $map;
    }

    /**
     * Карта всех "Ролей"
     * 
     * @param bool $onlyKeys По умолчанию `false`
     * @return array Ассоциативный массив или только ключи
     */
    private static function roleMap(bool $onlyKeys = false): array
    {
        $map = [
            self::ROLE_PERFORMER => 'Исполнитель',
            self::ROLE_CUSTOMER => 'Заказчик'
        ];

        return  $onlyKeys ? array_keys($map) : $map;
    }
}

/**
 * Кастомное базовое исключение
 */
class BaseTaskException extends Exception
{
}

/**
 * Базовое исключение "Состояний"
 */
class StatusTaskException extends BaseTaskException
{
}

/**
 * Базовое исключение "Действий"
 */
class ActionTaskException extends BaseTaskException
{
}

/**
 * Базовое исключение "Ролей"
 */
class RoleTaskException extends BaseTaskException
{
}

class NotValidStatusException extends StatusTaskException
{
    public function __construct(string $status, int $code = 0)
    {
        $message = "Не допустимое значение \"Состояния\" - {$status}";
        parent::__construct($message, $code);
    }
}

class NotAllowedStatusException extends StatusTaskException
{
    public function __construct(string $status, int $code = 0)
    {
        $message = "Не возможно изменить \"Состояние\" на '{$status}'";
        parent::__construct($message, $code);
    }
}

class NotValidActionException extends ActionTaskException
{
    public function __construct(string $action, int $code = 0)
    {
        $message = "Не допустимое значение \"Действия\" - {$action}";
        parent::__construct($message, $code);
    }
}

class NotAllowedActionException extends ActionTaskException
{
    public function __construct(string $action, int $code = 0)
    {
        $message = "Не возможно выполнить \"Действие\": '{$action}'";
        parent::__construct($message, $code);
    }
}

class UndefinedRoleException extends RoleTaskException
{
    public function __construct()
    {
        $message = "\"Роль\" не определена";
        parent::__construct($message);
    }
}

class NotFoundRoleException extends RoleTaskException
{
    public function __construct(string $role, int $code = 0)
    {
        $message = "Роль '{$role}' не найдена";
        parent::__construct($message, $code);
    }
}
