<?php

namespace app\actions\task;

use app\exceptions\action\NotOwnerActionException;

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
        if ($customerId !== $userId) {
            throw new NotOwnerActionException();
        }
        
        return true;
    }
}
