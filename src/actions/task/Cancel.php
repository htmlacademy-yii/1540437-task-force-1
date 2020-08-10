<?php

namespace app\bizzlogic\actions\task;

class Cancel extends AbstractTaskAction
{
    /** {@inheritdoc} */
    public function getName(): string
    {
        return 'Отменить';
    }

    /** {@inheritdoc} */
    public function internalName(): string
    {
        return 'act_cancel';
    }

    /** {@inheritdoc} */
    public function can(): bool
    {
        return true;
    }
}
