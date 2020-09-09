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

    /** {@inheritDoc} */
    public function getName(): string
    {
        return $this->_name;
    }

    /** {@inheritDoc} */
    public function getColumns(): array
    {
        return $this->_columns;
    }

    /** {@inheritDoc} */
    public function getRows(): array
    {
        return $this->_rows;
    }

    /** {@inheritDoc} */
    public function setName(string $name)
    {
        $this->_name = $name;
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
