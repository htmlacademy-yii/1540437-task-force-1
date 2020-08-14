<?php

namespace app\bizzlogic\actions\task;

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
        return $userId === $performerId;
    }
}
