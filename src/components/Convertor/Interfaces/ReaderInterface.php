<?php

namespace app\components\Convertor\Interfaces;

interface ReaderInterface
{
    /** @return string Имя источника данных */
    public function getSourceName(): string;

    /** @return array|null Данные */
    public function getData(): ?array;
}
