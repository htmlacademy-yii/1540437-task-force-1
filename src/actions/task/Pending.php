<?php

namespace app\bizzlogic\actions\task;

/** {@inheritDoc} */
class Pending extends AbstractTaskAction
{
    /** {@inheritdoc} */
    protected static function name(): string
    {
        return 'Откликнуться';
    }

    /** {@inheritdoc} */
    protected static function internalName(): string
    {
        return 'act_pending';
    }

    /** {@inheritdoc} */
    public function can(int $performerId, int $customerId, int $userId): bool
    {
        return $userId === $customerId;
    }
}
