<?php

namespace app\actions\task;

use app\exceptions\action\NotEnoughRightsActionException;

/** {@inheritDoc} */
class Pending extends AbstractTaskAction
{
    /** {@inheritdoc} */
    public static function name(): string
    {
        return 'Откликнуться';
    }

    /** {@inheritdoc} */
    public static function internalName(): string
    {
        return 'act_pending';
    }

    /** {@inheritdoc} */
    public function can(int $performerId, int $customerId, int $userId): bool
    {
        if ($userId !== $performerId) {
            throw new NotEnoughRightsActionException('Pending');
        }
        return true;
    }
}
