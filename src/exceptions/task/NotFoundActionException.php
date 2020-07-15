<?php

namespace app\exceptions\task;

use app\exceptions\base\TaskActionException;

/**
 * Если "Действие" задания не найдено
 */
class NotFoundActionExceptions extends TaskActionException
{
    /**
     * Схема "Исключения"
     * 
     * @param string $action Действие
     * @param int $code Код исключения, по умолчанию 0
     */
    public function __construct(string $action, int $code = 0)
    {
        $message = "Не допустимое значение \"Действия\" - {$action}";
        parent::__construct($message, $code);
    }
}
