<?php

namespace app\bizzlogic\actions\task;

/** {@inheritDoc} */
class Complete extends AbstractTaskAction
{
    /** {@inheritdoc} */
    protected static function name(): string
    {
        return 'Завершить';
    }

    /** {@inheritdoc} */
    protected static function internalName(): string
    {
        return 'act_complete';
    }

    /** {@inheritdoc} */
    public function can(int $performerId, int $customerId, int $userId): bool
    {
        return $userId === $customerId;
    }
}
