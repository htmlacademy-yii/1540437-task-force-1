<?php

namespace app\components\Convertor\Interfaces;

use app\components\Convertor\interfaces\DataTransferInterface;

interface WriterInterface
{
    /** @param DataTransferInterface $dataObject Объект данных */
    public function setData(DataTransferInterface $dataObject);

    /**
     * Сохранить данные в фаиле
     *
     * @param string $data
     * @return int Колво записанных байт
     */
    public function saveAsFile(string $data): int;

    /** @return string */
    public function generate(): string;
}
