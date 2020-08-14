<?php

namespace app\bizzlogic\actions\task;

abstract class AbstractTaskAction
{

    /**
     * @return string Название действия
     */
    abstract protected static function name(): string;

    /**
     * @return string Внтуреннее имя
     */
    abstract protected static function internalName(): string;

    /**
     * Проверка прав на выполеннеи действия
     * 
     * @param int $performerId Исполнитель
     * @param int $customerId Заказчик
     * @param int $userId Пользователь
     * @return bool
     */
    abstract public function can(int $performerId, int $customerId, int $userId): bool;
}
