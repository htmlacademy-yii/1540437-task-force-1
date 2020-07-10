<?php

/**
 * Базовый класс Задач
 * 
 * @property int $id ID Задачи
 * @property int $performer_id ID Исполнителя 
 * @property int $customer_id ID Заказчика
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

    /** Заказчик разместил новое задание */
    const ACTION_CUSTOMER_CREATE = 'actionCreate';
    /** Заказчик отменил задание */
    const ACTION_CUSTOMER_CANCEL = 'actionCancel';
    /** Заказчик выбрал исполнителя */
    const ACTION_CUSTOMER_APPROVE = 'actionApprove';
    /** Заказчик пометил задание как Завершенное */
    const ACTION_CUSTOMER_COMPLETE = 'actionComplete';

    /** Исполнитель откликнулся на новое задание */
    const ACTION_PERFORMER_PENDING = 'actionPending';
    /** Исполнитель отказался от задания */
    const ACTION_PERFORMER_REFUSE = 'actionRefuse';
    /** Исполнитель начинает выполнение задания */
    const ACTION_PERFORMER_START = 'actionStart';

    protected static $_constants;

    public int $id;
    public int $customerId;
    public int $performerId;
    public string $status;

    /**
     * Создание новой схемы 'Задачи'.
     * 
     * @param int $customer ID Заказчика
     * @param int $performer ID Исполнителя
     * @return void
     */
    public function __construct(int $customer, int $performer)
    {
        $this->customerId = $customer;
        $this->performerId = $performer;
    }

    /** Заказчик разместил новое задание */
    public function actionCreate()
    {
        $this->id = random_int(10, 9999);
        $this->status = self::STATUS_NEW;
        return $this->status;
    }

    /** Заказчик отменил задание */
    public function actionCancel()
    {
        if ($this->canRunAction(__FUNCTION__) && $this->changeStatus(self::STATUS_CANCELED)) {
            return $this->status;
        }
        return false;
    }

    /** Заказчик выбрал исполнителя */
    public function actionApprove()
    {
        if ($this->canRunAction(__FUNCTION__) && $this->changeStatus(self::STATUS_INPROGRESS)) {
            return $this->status;
        }
        return false;
    }

    /** Заказчик отказался от задания */
    public function actionRefuse()
    {
        if ($this->canRunAction(__FUNCTION__) && $this->changeStatus(self::STATUS_FAIL)) {
            return $this->status;
        }
        return false;
    }

    /**
     * Заказчик пометил задание как Завершенное
     * @return string|boolean Новый статус или `false`
     */
    public function actionComplete()
    {
        if ($this->canRunAction(__FUNCTION__) && $this->changeStatus(self::STATUS_COMPLETE)) {
            return $this->status;
        }
        return false;
    }

    /** Исполнитель предложил свои услуги */
    public function actionPending()
    {
        if ($this->canRunAction(__FUNCTION__)) {
            return $this->status;
        }
        return false;
    }

    /** Исполнитель начал выполнять задание */
    public function actionStart()
    {
        if ($this->canRunAction(__FUNCTION__) && $this->changeStatus(self::STATUS_INPROGRESS)) {
            return $this->status;
        }
        return false;
    }

    /** Исполнитель завершил задание */
    public function actionDone()
    {
        if ($this->canRunAction(__FUNCTION__)) {
            return true;
        }
        return false;
    }

    /** 
     * Изменение статуса задания
     * 
     * @param string $status Новый статус.
     * @return string|false Статус задания
     */
    private function changeStatus(string $status)
    {
        if (!isset($this->status)) {
            $this->status = self::STATUS_NEW;
        }

        if ($this->status === $status) {
            return $this->status;
        }

        if (self::isStatusValid($status) && $this->canChangeStatus($status)) {
            $this->status = $status;
        } else {
            return false;
        }

        return $this->status;
    }

    /** 
     * Проверят, допускается ли изменение статуса
     * @param string $status
     * @return bool
     */
    private function canChangeStatus(string $status): bool
    {
        $statusChain = [
            self::STATUS_NEW => [
                self::STATUS_CANCELED, self::STATUS_INPROGRESS
            ],
            self::STATUS_INPROGRESS => [
                self::STATUS_COMPLETE, self::STATUS_FAIL
            ]
        ];

        if (!isset($statusChain[$this->status])) {
            return false;
        }

        return in_array($status, $statusChain[$this->status]);
    }

    /**
     * Проверяет, допускаетлся выполнение Действия
     *
     * @param string $action
     * @return bool
     */
    private function canRunAction(string $action): bool
    {
        $actionChain = [
            self::STATUS_NEW => [
                self::ACTION_CUSTOMER_APPROVE,
                self::ACTION_CUSTOMER_CANCEL,
                self::ACTION_PERFORMER_PENDING,
                self::ACTION_PERFORMER_START
            ],
            self::STATUS_INPROGRESS => [
                self::ACTION_CUSTOMER_CANCEL,
                self::ACTION_CUSTOMER_COMPLETE,
                self::ACTION_PERFORMER_REFUSE
            ]
        ];
        if (!isset($actionChain[$this->status])) {
            return false;
        }

        return in_array($action, $actionChain[$this->status]);
    }

    /**
     * Проверяет соответсвие запрашиваемого статуса к списку возможных статусов.
     * 
     * @property string $status Именованный статус задания.
     * @return boolean true or false
     */
    private static function isStatusValid(string $status)
    {
        $statusList = array_values(self::StatusList());
        if (in_array($status, $statusList)) {
            return true;
        } else {
            echo "Состояние '{$status}' не входит с писок допустимых.\n";
            echo "Не пытайтесь в ручную указывать состояние задачи, используйте доступные действия.\n";
            return false;
        }
    }

    /** @return array Список доступных состояний */
    private static function StatusList()
    {
        return self::constants('status_');
    }

    /**
     * @param string $prefix Prefix
     * @return array[] $constants
     */
    private static function constants(string $prefix = '')
    {
        if (!self::$_constants) {
            $reflectionClass = new ReflectionClass(__CLASS__);
            self::$_constants = $reflectionClass->getConstants();
        }

        if (strlen($prefix)) {
            $prefix = strtoupper($prefix);
            $result = [];
            foreach (self::$_constants as $n => $v) {
                if ((strpos($n, $prefix)) !== false) {
                    $result[$n] = $v;
                }
            }
            return $result;
        }

        return self::$_constants;
    }
}
