<?php

namespace app\bizzlogic\actions\task;

/** {@inheritDoc} */
class Refuse extends AbstractTaskAction
{
    /** {@inheritdoc} */
    protected static function name(): string
    {
        return 'Отказаться';
    }

    /** {@inheritdoc} */
    protected static function internalName(): string
    {
        return 'act_refuse';
    }

    /** {@inheritdoc} */
    public function can(int $performerId, int $customerId, int $userId): bool
    {
        return $userId === $performerId;
    }
}
