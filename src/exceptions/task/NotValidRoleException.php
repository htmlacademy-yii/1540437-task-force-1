<?php

namespace app\exceptions\task;

use app\exceptions\base\TaskRoleException;

/**
 * Если Роль в "Заданиях" не найдена
 */
class NotValidRoleException extends TaskRoleException
{
    /**
     * @param string $role Роль
     * @param int $code Код исключения
     */
    public function __construct(string $role, int $code = 0)
    {
        $message = "Роль '{$role}' не найдена";
        parent::__construct($message, $code);
    }
}
