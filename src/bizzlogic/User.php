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

    /** @var string Мужской */
    const GENDER_MALE = 'MALE';
    /** @var string Женский */
    const GENDER_FEMALE = 'FEMALE';

    /** @return array Список доступных гендерных признаков */
    public static function genderMap(?string $gender = null): array
    {
        return [
            self::GENDER_MALE => 'man',
            self::GENDER_FEMALE => 'woman'
        ];
    }

    /** @return Array Список доступных ролей */
    public static function roleMap(): array
    {
        return [
            self::ROLE_CUSTOMER => 'Заказчик',
            self::ROLE_PERFORMER => 'Исполнитель'
        ];
    }
}
