<?php

namespace app\actions\task;

use app\exceptions\action\NotOwnerActionException;

/** {@inheritDoc} */
class Refuse extends AbstractTaskAction
{
    /** {@inheritdoc} */
    public static function name(): string
    {
        return 'Отказаться';
    }

    /** {@inheritdoc} */
    public static function internalName(): string
    {
        return 'act_refuse';
    }

    /** {@inheritdoc} */
    public function can(int $performerId, int $customerId, int $userId): bool
    {
        if ($userId !== $performerId) {
            throw new NotOwnerActionException();
        }
        return true;
    }
}
