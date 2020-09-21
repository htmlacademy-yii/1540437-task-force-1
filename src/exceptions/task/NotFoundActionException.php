<?php

namespace app\exceptions\task;

/**
 * Если "Действие" задания не найдено
 */
class NotFoundActionException extends TaskActionException
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
