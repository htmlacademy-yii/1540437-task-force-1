<?php

namespace app\exceptions\action;

use app\exceptions\base\ActionException;

class NotFoundActionException extends ActionException
{
    /**
     * Схема "Исключения"
     *
     * @param string $action Действие
     * @param int $code Код исключения, по умолчанию 0
     */
    public function __construct(string $action, int $code = 0)
    {
        $message = "Запрашиваемое \"Действие\": '{$action}' не найдено";
        parent::__construct($message, $code);
    }
}
