<?php

/**
 * Базоый класс Бизнеслогики Заданий
 *
 * @author Alexey Pozhidaev <worka@bk.ru>
 * @link   https://github.com/AlexBad
 */

namespace app\bizzlogic;

class User
{
    /** @var int Заказчик */
    const ROLE_CUSTOMER = 1;
    /** @var int Исполнитель */
    const ROLE_PERFORMER = 2;

    /** @return Array Список доступных ролей */
    public static function roleMap(): array
    {
        return [
            self::ROLE_CUSTOMER => 'Заказчик',
            self::ROLE_PERFORMER => 'Исполнитель'
        ];
    }
}
