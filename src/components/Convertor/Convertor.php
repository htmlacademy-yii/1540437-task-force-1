<?php

namespace app\components\Convertor;

use app\components\Convertor\Interfaces\ReaderInterface;
use app\components\Convertor\Interfaces\WriterInterface;
use app\components\Convertor\interfaces\DataTransferInterface;
use DataTransferInterfaceException;

class Convertor
{
    public $dtoClass = 'app\components\Convertor\DbDataObject';

    /** @var ReaderInterface */
    private $_reader;

    /** @var WriterInterface */
    private $_writer;

    /** @var DataTransferInterface  */
    private $_dto;

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
        $this->initDto();
    }

    /** Конвертация данных */
    public function convert(): void
    {
        $dto = $this->getDto();
        $dto->setName($this->_reader->getSourceName());

        // $this->getDto()->addColumn();
        // $fileName = $this->getSrcName();
        // $this->writer->generateFileName($fileName);
        // $this->writer->generate($this->reader);

        // $this->writer->saveAsFile($fileName, $data);
    }

    /** @return DataTransferInterface */
    private function getDto(): DataTransferInterface
    {
        return $this->_dto;
    }

    /**
     * Инициализация `ДТО Объекта`
     *
     * @return void
     * @throws DataTransferInterfaceException Если класс не является наследником
     */
    private function initDto(): void
    {
        $dto = new $this->dtoClass;

        if (!$dto instanceof DataTransferInterface) {
            throw new DataTransferInterfaceException($dto, 'DataTransferInterface');
        }

        /** @var DataTransferInterface $dto */
        $dto->setColumns($this->_reader->getColumns());
        $dto->setRows($this->_reader->getRows());
        $this->_dto = $dto;
    }
}
