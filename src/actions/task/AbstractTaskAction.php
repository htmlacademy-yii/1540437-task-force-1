<?php

namespace app\actions\task;

abstract class AbstractTaskAction
{
    /**
     * @return string Название действия
     */
    abstract protected function getName(): string;

    /**
     * @return string Внтуреннее имя
     */
    abstract protected function internalName(): string;

    /**
     * @return bool Проверка прав
     */
    abstract public function can(): bool;
}
