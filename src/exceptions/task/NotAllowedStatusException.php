<?php

namespace app\exceptions\task;

use app\exceptions\base\TaskStatusException;

/**
 * Если "Задание" не позволяет изменить "Состояние"
 * 
 * @inheritdoc
 */
class NotAllowedStatusException extends TaskStatusException
{
    /** 
     * @param string $status "Состояние" задачи
     * @param int $code Код исключения
     */
    public function __construct(string $status, int $code = 0)
    {
        $message = "Не возможно изменить \"Состояние\" на '{$status}'";
        parent::__construct($message, $code);
    }
}
