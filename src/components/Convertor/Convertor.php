<?php
namespace app\components\Convertor;

use app\components\Convertor\Readers\AbstractFileReader;
use app\components\Convertor\Writers\AbstractWriter;

class Convertor
{
    /** @var AbstractFileReader */
    private $reader;
    /** @var AbstractWriter */
    private $writer;


    public function __construct(AbstractFileReader $reader, AbstractWriter $writer)
    {
        $this->reader = $reader;
        $this->writer = $writer;
    }

    /** Конвертация данных */
    public function convert(): void
    {
        $fileName = $this->writer->generateFileName($this->reader);
        $data = $this->writer->generate($this->reader);

        $this->writer->saveAsFile($fileName, $data);
    }
}
