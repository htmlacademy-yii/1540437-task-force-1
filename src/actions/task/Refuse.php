<?php

namespace app\actions\task;

class Refuse extends AbstractTaskAction
{
    /** {@inheritdoc} */
    public function getName(): string
    {
        return 'Отказаться';
    }

    /** {@inheritdoc} */
    public function internalName(): string
    {
        return 'act_refuse';
    }

    /** {@inheritdoc} */
    public function can(): bool
    {
        return true;
    }
}
