<?php

namespace app\components\Convertor\Interfaces;

use app\components\Convertor\interfaces\DataTransferInterface;

interface WriterInterface
{
    /** @param DataTransferInterface $dataObject Объект данных */
    public function withData(DataTransferInterface $dataObject): self;

    /**
     * Сохранить данные в фаиле
     *
     * @return int Кол-во записанных байт
     */
    public function save(): int;

    /** @return string */
    public function toString(): self;
}
