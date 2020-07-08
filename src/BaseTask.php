<?php

/**
 * Базовый класс Задач
 * 
 * @property int $id ID Задачи
 * @property int $performer_id ID Исполнителя 
 * @property int $customer_id ID Заказчика
 * @property string $status Статус задачи
 * @property string $role Роль пользваотеля
 */
class BaseTask
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
    /** Заказчик отказался от задания */
    const ACTION_CUSTOMER_REFUSE = 'actionRefuse';
    /** Заказчик пометил задание как Завершенное */
    const ACTION_CUSTOMER_COMPLETE = 'actionComplete';

    /** Исполнитель откликнулся на новое задание */
    const ACTION_PERFORMER_PENDING = 'actionPeding';
    /** Исполнитель начинает выполнение задания */
    const ACTION_PERFORMER_START = 'actionStart';
    /** Исполнитель завершил задание  */
    const ACTION_PERFORMER_DONE = 'actionDone';

    protected static $_constants;

    public $id;
    public $customer_id;
    public $performer_id;
    public $status;
    public $complete;

    /**
     * Создание новой схемы 'Задачи'.
     * 
     * @param integer $customer ID Заказчика
     * @param integer $performer ID Исполнителя
     */
    public function __construct($customer, $performer)
    {
        $this->customer_id = $customer;
        $this->performer_id = $performer;
        $this->status = self::STATUS_NEW;
        $this->complete = false;
    }

    /** Заказчик разместил новое задание */
    public function actionCreate()
    {
        $this->id = random_int(10, 9999);
        $this->changeStatus(self::STATUS_NEW);
    }

    /** Заказчик отменил задание */
    public function actionCancel()
    {
        $this->changeStatus(self::STATUS_CANCELED);
    }

    /** Заказчик отказался от задания */
    public function actionRefuse()
    {
        $this->changeStatus(self::STATUS_FAIL);
    }

    /** Заказчик пометил задание как Завершенное */
    public function actionComplete()
    {
        $this->changeStatus(self::STATUS_COMPLETE);
    }

    /** Исполнитель начал выполнение задания */
    public function actionPending()
    {
        $this->changeStatus(self::STATUS_INPROGRESS);
    }
    /** Исполнитель начал выполнять задание */
    public function actionStart()
    {
        $this->changeStatus(self::STATUS_INPROGRESS);
    }

    /** Исполнитель завершил задание */
    public function actionDone()
    {
        $this->changeStatus(self::STATUS_COMPLETE);
    }

    /** 
     * Изменение статуса задания на новый
     * @param string $status Новый статус.
     * @return string Статус задания
     */
    private function changeStatus(string $status)
    {
        echo "\n- Пытаюсь изменить состояние задания на '{$status}'\n";
        if (self::isStatusValid($status)) {
            $this->status = $status;
            /** Todo
             *  Добавить проверку на изменение статуса в зависимости от текущего статуса.
             */
            echo "-- Состояние задания изменено на '{$status}'\n";
            echo "-- Список доступных действий: [ " . implode(', ', $this->avaiableActions()) . " ]\n";
        } else {
            echo "-- Error:  Не удалось изменить Состояние задания на '{$status}'\n\n";
        }

        return $this->status;
    }

    /**
     * Возвращает список доступных `Действий` для текущего `Статуса`.
     * @return array|null
     */
    public function getActionList()
    {
        $list = [
            self::STATUS_DRAFT => [self::ACTION_TASK_CREATE],
            self::STATUS_NEW => []
        ];

        return ['create', 'close'];
    }

    /** @return array Список доступных действий */
    private function avaiableActions()
    {
        $statusActions[self::STATUS_NEW] = [
            self::ACTION_CUSTOMER_CANCEL,
            self::ACTION_PERFORMER_PENDING,
            self::ACTION_PERFORMER_START
        ];

        $statusActions[self::STATUS_INPROGRESS] = [
            self::ACTION_CUSTOMER_COMPLETE,
            self::ACTION_CUSTOMER_REFUSE,
            self::ACTION_PERFORMER_DONE,
        ];

        return isset($statusActions[$this->status]) ? $statusActions[$this->status] : [];
    }



    public static function actionMap($action)
    {

        if (!in_array($action, self::constants('action_task_'))) {
            echo "!Запрашиваемое действие '{$action}' не доступного для данного класса.";
            echo "\n------------\n";
        }
    }

    /**
     * Проверяет соответсвие запрашиваемого статуса с списку статусов.
     * 
     * @property string $status Именованный статус задания.
     * @return boolean true or false
     */
    public static function isStatusValid(string $status)
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

    /** @return array List available statuses */
    private static function StatusList()
    {
        return array_values(self::constants('status_'));
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
