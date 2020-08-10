<?php

namespace app\actions\task;

class Pending extends AbstractTaskAction
{
    /** {@inheritdoc} */
    public function getName(): string
    {
        return 'Откликнуться';
    }

    /** {@inheritdoc} */
    public function internalName(): string
    {
        return 'act_pending';
    }

    /** {@inheritdoc} */
    public function can(): bool
    {
        return true;
    }
}
