<?php

namespace app\components\Convertor;

use app\components\Convertor\Interfaces\ReaderInterface;
use app\components\Convertor\Interfaces\WriterInterface;

class Convertor
{
    /** @var ReaderInterface */
    private $reader;

    /** @var WriterInterface */
    private $writer;

    /**
     * Convertor конструктор класса
     *
     * @param ReaderInterface $reader
     * @param WriterInterface $writer
     */
    public function __construct(ReaderInterface $reader, WriterInterface $writer)
    {
        $this->reader = $reader;
        $this->writer = $writer;
    }

    /** Конвертация данных */
    public function convert(): void
    {
        $dto = $this->reader->getData();
        $this->writer->setData($dto);
        $data = $this->writer->generate();
        $this->writer->saveAsFile($data);
    }
}
