<?php

/**
 * Базоый класс Бизнеслогики
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
use app\exceptions\action\NotEnoughRightsActionException;
use app\exceptions\base\ActionException;
use app\exceptions\task\NotAllowedActionException;
use app\exceptions\task\NotAllowedStatusException;
use app\exceptions\task\NotValidActionException;
use app\exceptions\task\NotValidRoleException;
use app\exceptions\task\NotValidStatusException;

/**
 * @property int $userId ID текущего пользователя
 * @property int $performerId ID Исполнителя
 * @property int $customerId ID Заказчика
 * @property string $status Статус задачи
 */
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

    /** Исполнитель */
    const ROLE_PERFORMER = 'PERFORMER';
    /** Заказчик */
    const ROLE_CUSTOMER = 'CUSTOMER';

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
     * @param string $action `Действие`
     * @return string|null Наименование Состояния
     */
    public function getNextStatus(string $action): ?string
    {
        $map = [
            ActionPending::internalName() => self::STATUS_INPROGRESS,
            ActionRefuse::internalName() => self::STATUS_FAIL,
            ActionCancel::internalName() => self::STATUS_CANCELED,
            ActionComplete::internalName() => self::STATUS_COMPLETE
        ];

        return isset($map[$action]) ? $map[$action] : null;
    }

    /**
     * Заказчик отменил задание
     *
     * @param string $role Роль пользователя
     * @param int $usrId Ид пользователя
     * @return string $status
     */
    public function actionCancel(string $role, int $userId): string
    {
        $this->runAction(new ActionCancel(), $role, $userId);
        return $this->status;
    }

    /**
     * Исполнитель отказался от выполнения задания.
     *
     * @param string $role
     * @param int $userId
     * @return string $status
     */
    public function actionRefuse(string $role, int $userId): string
    {
        $this->runAction(new ActionRefuse(), $role, $userId);
        return $this->status;
    }

    /**
     * Заказчик пометил задание как `Завершенное`.
     *
     * @param string $role Роль пользователя
     * @param int $userId ИД Пользователя
     * @return string $status
     */
    public function actionComplete(string $role, $userId): string
    {
        $this->runAction(new ActionComplete(), $role, $userId);
        return $this->status;
    }

    /**
     * Исполнитель предложил свои услуги.
     *
     * @param string $role
     * @return string $status
     */
    public function actionPending(string $role, int $userId): string
    {
        $this->runAction(new ActionPending(), $role, $userId);
        return $this->status;
    }

    /**
     * Выполнение Действия
     *
     * @param AbstractTaskAction $action
     * @param string $role
     * @param int $userId
     * @return bool
     * @throws NotEnoughRightsActionException Если нет прав
     */
    private function runAction(AbstractTaskAction $action, string $role, int $userId): bool
    {
        if (!$action->can($this->performerId, $this->customerId, $userId)) {
            throw new NotEnoughRightsActionException($action::internalName());
        }
        $this->changeStatus($action::internalName(), $role);
        return true;
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
     * Устанавливает новое "Состояние" для приложения
     *
     * @param string $status
     */
    private function setStatus(string $status): void
    {
        $this->status = $status;
    }

    /**
     * Изменяет "Состояние" после выполнения "Действия"
     *
     * @param string $currentAction Текущее действие.
     * @return void
     * @throws NotAllowedStatusException Если нельзя изменить "Статус"
     * @throws NotAllowedActionException Если нельзя выполнить "Действие"
     */
    private function changeStatus(string $currentAction, string $role): void
    {
        $newStatus = $this->getNextStatus($currentAction);

        if (!$this->canChangeStatus($newStatus)) {
            throw new NotAllowedStatusException($newStatus);
        }

        if (!$this->canRunAction($currentAction, $role)) {
            throw new NotAllowedActionException($currentAction);
        }

        $this->setStatus($newStatus);
    }

    /**
     * Проверка на наличие `Исполнителя` в `Задании`.
     *
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
     */
    private function getRoleActions(string $role): array
    {
        $actions = self::listRoleActions();
        return isset($actions[$role]) ? $actions[$role] : [];
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
     * @param string $role Роль
     * @return array
     */
    private function getAllowedActionsList(string $role): array
    {
        $roleActions = $this->getRoleActions($role);
        $statusActions = $this->getStatusActions();

        return array_intersect($roleActions, $statusActions);
    }

    /**
     * Список доступных "Состояний"
     *
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
     * @param string $role Роль пользователя
     * @return bool
     * @throws NotValidActionException Если не корректное "Действие"
     * @throws NotValidRoleException Если не корректная "Роль"
     */
    protected function canRunAction(string $action, string $role): bool
    {
        if (!self::isActionValid($action)) {
            throw new NotValidActionException($action);
        }

        if (!self::isRoleValid($role)) {
            throw new NotValidRoleException($role);
        }

        return in_array($action, $this->getAllowedActionsList($role));
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
     * @param string $role
     * @return bool
     */
    private static function isRoleValid(string $role) : bool
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
     * @return array [ status => [...Actions name]]
     */
    private static function listStatusActions(): array
    {
        return [
            self::STATUS_NEW => [
                ActionCancel::internalName(),
                ActionPending::internalName()
            ],
            self::STATUS_INPROGRESS => [
                ActionCancel::internalName(),
                ActionComplete::internalName(),
                ActionRefuse::internalName()
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
                ActionCancel::internalName(),
                ActionComplete::internalName(),
            ],
            self::ROLE_PERFORMER => [
                ActionPending::internalName(),
                ActionRefuse::internalName(),
            ]
        ];
    }

    /**
     * Карта всех Действий.
     *
     * @param bool $onlyKeys По умалчанию `false`
     * @return array Ассоциативный массив или только ключи
     */
    private static function actionMap(bool $onlyKeys = false): array
    {
        $map = [
            ActionCancel::internalName() => ActionCancel::name(),
            ActionComplete::internalName() => ActionComplete::name(),
            ActionPending::internalName() => ActionPending::name(),
            ActionRefuse::internalName() => ActionRefuse::name(),
        ];

        return $onlyKeys ? array_keys($map) : $map;
    }

    /**
     * Карта всех Статусов.
     *
     * @param bool $onlyKeys По умолчанию `false`
     * @return array Ассоциативный массив или только ключи
     */
    private static function statusMap(bool $onlyKeys = false): array
    {
        $map = [
            self::STATUS_NEW => 'Новое',
            self::STATUS_CANCELED => 'Отменено',
            self::STATUS_COMPLETE => 'Завершено',
            self::STATUS_FAIL => 'Провалено',
            self::STATUS_INPROGRESS => 'Выполняется'
        ];

        return  $onlyKeys ? array_keys($map) : $map;
    }

    /**
     * Карта всех Ролей
     *
     * @param bool $onlyKeys
     *
     * @return array
     */
    private static function roleMap(bool $onlyKeys = false) : array
    {
        $map = [
            self::ROLE_CUSTOMER => 'Заказчик',
            self::ROLE_PERFORMER => 'Исполнитель'
        ];

        return  $onlyKeys ? array_keys($map) : $map;
    }
}
