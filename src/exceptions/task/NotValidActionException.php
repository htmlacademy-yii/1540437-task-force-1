<?php

namespace app\exceptions\task;

/**
 * {@inheritdoc}
 */
class NotValidActionException extends NotFoundActionExceptions
{
    /** {@inheritdoc} */
    public function __construct(string $action, int $code = 0)
    {
        $message = "Не допустимое значение \"Действия\" - {$action}";
        parent::__construct($message, $code);
    }
}
