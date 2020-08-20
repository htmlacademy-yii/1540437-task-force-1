<?php

namespace app\exceptions\action;

use app\exceptions\base\ActionException;

/**
 * Если пользователь не является владельцем
 */
class NotOwnerActionException extends ActionException
{
    /**
     * Схема "Исключения"
     *
     * @param int $code Код исключения, по умолчанию 0
     */
    public function __construct(int $code = 0)
    {
        $message = "Только владелец имеет возможность выполнить запрашиваемое действие";
        parent::__construct($message, $code);
    }
}
