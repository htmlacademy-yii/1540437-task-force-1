<?php

namespace app\components\Convertor;

use app\components\Convertor\interfaces\DataTransferInterface;

class DbDataObject implements DataTransferInterface
{
    /** @var string */
    private $_name;
    /** @var array */
    private $_columns = [];
    /** @var array */
    private $_rows = [];


    /** @return string $name */
    public function getName(): string
    {
        return $this->_name;
    }

    public function setName(string $name)
    {
        $this->_name = $name;
    }

    public function addRow(string $row)
    {
        $this->_rows[] = $row;
    }

    /** {@inheritDoc} */
    public function addColumn(string $columnName)
    {
        if (!in_array($columnName, $this->_columns)) {
            $this->_columns[] = $columnName;
        }
    }

    /** {@inheritDoc} */
    public function getRows(): array
    {
        return $this->_rows;
    }

    /** {@inheritDoc} */
    public function getColumns(): array
    {
        return $this->_columns;
    }

    /** {@inheritDoc} */
    public function setRows(array $rowsData)
    {
        $this->_rows = $rowsData;
    }

    /** {@inheritDoc} */
    public function setColumns(array $columnsData)
    {
        $this->_columns = $columnsData;
    }
}
