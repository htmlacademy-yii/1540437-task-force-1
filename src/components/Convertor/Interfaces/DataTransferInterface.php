<?php
namespace app\components\Convertor\interfaces;

interface DataTransferInterface
{
    /** @return string $name */
    public function getName(): string;

    /** @param string $name */
    public function setName(string $name);

    /** @param string $rowData - Добавить данные строки */
    public function addRow(string $rowData);

    /** @param string $columnName - Добавить заголовок */
    public function addColumn(string $columnName);

    /** @param array $rowsData Массив строк */
    public function setRows(array $rowsData);
    
    /** @param array $rowsData Массив заголовок */
    public function setColumns(array $columnsData);

    /** @return array Строки */
    public function getRows(): array;
    /** @return array Колонки */
    public function getColumns(): array;
}
