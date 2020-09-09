<?php

namespace app\components\Convertor\interfaces;

interface DataTransferInterface
{
    /** @return string Имя */
    public function getName(): string;

    /** @return array Строки */
    public function getRows(): array;

    /** @return array Колонки */
    public function getColumns(): array;

    /** @param string $name */
    public function setName(string $name);

    /** @param array $rows */
    public function setRows(array $rows);

    /** @param array $columns */
    public function setColumns(array $columns);
}
