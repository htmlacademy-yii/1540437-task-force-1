<?php

namespace app\actions\task;

/**
 * Для тестов, для проерка на не описанный Action в логике.
 */
class Undefined extends AbstractTaskAction
{
    /** {@inheritdoc} */
    public static function name(): string
    {
        return 'Не известный';
    }

    /** {@inheritdoc} */
    public static function internalName(): string
    {
        return 'act_undefined';
    }

    /** {@inheritdoc} */
    public function can(int $performerId, int $customerId, int $userId): bool
    {
        return false;
    }
}
