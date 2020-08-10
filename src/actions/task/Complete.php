<?php

namespace app\actions\task;

class Complete extends AbstractTaskAction
{
    /** {@inheritdoc} */
    public function getName(): string
    {
        return 'Завершить';
    }

    /** {@inheritdoc} */
    public function internalName(): string
    {
        return 'act_complete';
    }

    /** {@inheritdoc} */
    public function can(): bool
    {
        return true;
    }
}
