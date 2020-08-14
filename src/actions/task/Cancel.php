<?php

namespace app\bizzlogic\actions\task;


/** {@inheritDoc} */
class Cancel extends AbstractTaskAction
{
    /** {@inheritdoc} */
    public static function name(): string
    {
        return 'Отменить';
    }

    /** {@inheritdoc} */
    public static function internalName(): string
    {
        return 'act_cancel';
    }

    /** {@inheritdoc} */
    public function can(int $performerId, int $customerId, int $userId): bool
    {
        return $customerId === $userId;
    }
}
