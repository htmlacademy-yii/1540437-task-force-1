<?php

namespace app\components\Convertor;

use app\components\Convertor\Interfaces\ReaderInterface;
use app\components\Convertor\Interfaces\WriterInterface;
use app\components\Convertor\ConverterDataObject;

class Convertor
{
    /** @var ReaderInterface */
    private $_reader;
    /** @var WriterInterface */
    private $_writer;

    /** @var ConverterDataObject */
    private $_data;

    /**
     * Convertor конструктор класса
     *
     * @param ReaderInterface $reader
     * @param WriterInterface $writer
     */
    public function __construct(ReaderInterface $reader, WriterInterface $writer)
    {
        $this->_reader = $reader;
        $this->_writer = $writer;
        $this->_data = new ConverterDataObject($reader);
    }

    /** Конвертация данных */
    public function convert(): void
    {
        $fileName = $this->getSrcName();
        $this->writer->generateFileName($fileName);
        $this->writer->generate($this->reader);

        $this->writer->saveAsFile($fileName, $data);
    }

    private function getSrcName()
    {
        return $this->_reader->getFileName();
    }

    private function getDestName()
    {
        return $this->writer->
    }
}
