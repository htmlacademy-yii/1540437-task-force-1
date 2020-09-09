<?php

namespace app\components\Convertor\Interfaces;

use app\components\Convertor\interfaces\DataTransferInterface;

interface ReaderInterface
{
    /** @return string Имя источника */
    public function getSourceName(): string;

    /** @return DataTransferInterface */
    public function getData(): DataTransferInterface;
}
