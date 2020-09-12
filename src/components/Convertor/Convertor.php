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
<<<<<<< HEAD
        $dto = $this->reader->getData();
        $this->writer->setData($dto);
        $data = $this->writer->generate();
        $this->writer->saveAsFile($data);
=======
        $dto = $this->reader->getDto();
        $this->writer->setData($dto);
        $data = $this->writer->generate();
        $this->writer->saveAsFile($data);

        // $this->getDto()->addColumn();
        // $fileName = $this->getSrcName();
        // $this->writer->generateFileName($fileName);
        // $this->writer->generate($this->reader);

        // $this->writer->saveAsFile($fileName, $data);
>>>>>>> 37da8738c7d731e74af13a60327ab798e30b20a8
    }
}
