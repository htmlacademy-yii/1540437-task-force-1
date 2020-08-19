<?php

namespace app\actions\task;

use app\exceptions\action\NotOwnerActionException;

/** {@inheritDoc} */
class Complete extends AbstractTaskAction
{
    /** {@inheritdoc} */
    public static function name(): string
    {
        return 'Завершить';
    }

    /** {@inheritdoc} */
    public static function internalName(): string
    {
        return 'act_complete';
    }

    /** {@inheritdoc} */
    public function can(int $performerId, int $customerId, int $userId): bool
    {
        if ($userId !== $customerId) {
            throw new NotOwnerActionException();
        }
        return true;
    }
}
