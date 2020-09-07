<?php

namespace app\components\Convertor;

class ConverterDataObject
{
    /** @var mixed $_data */
    private $_data;

    public function setData($data): void
    {
        $this->_data = $data;
    }

    /** @return mixed $data */
    public function getData()
    {
        return $this->_data;
    }
}
