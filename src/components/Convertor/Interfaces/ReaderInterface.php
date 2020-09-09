<?php

namespace app\components\Convertor\Interfaces;

interface ReaderInterface
{
    /** @return string Имя источника данных */
    public function getSourceName(): string;

    /** @return array Данные для строк */
    public function getRows(): array;

    /** @return array Данные для колонки */
    public function getColumns(): array;
}
