<?php

namespace app\exceptions\task;

use app\exceptions\base\TaskStatusException;

/**
 * Если значение Состояния не допустимо
 */
class NotValidStatusException extends TaskStatusException
{
    /**
     * @param string $status "Состояние"
     * @param int $code Код исключения, по умолчанию 0
     */
    public function __construct(string $status, int $code = 0)
    {
        $message = "Не допустимое значение \"Состояния\" - {$status}";
        parent::__construct($message, $code);
    }
}
