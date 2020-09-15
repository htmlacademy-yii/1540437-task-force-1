<?php

namespace app\components\Convertor\Readers;

use app\components\Convertor\DataTransferObject;
use app\components\Convertor\DbDataObject;
use app\components\Convertor\interfaces\DataTransferInterface;
use app\components\Convertor\Interfaces\ReaderInterface;

/** {@inheritDoc} */
class CsvReader implements ReaderInterface
{
    /** @var \SplFileObject $spl */
    private $spl;

    /** {@inheritDoc} */
    public function getSourceName(): string
    {
        return $this->getFileName(false);
    }

    /**
     * Установить Объект класса чтения файлов \SplFileObject
     *
     * @param string $fileName
     * @param string|null $fileMod
     * @return void
     */
    public function setFile(string $fileName, string $fileMod = 'r')
    {
        $this->spl = new \SplFileObject($fileName, $fileMod);
        $this->updateFileFlags();
    }

    /** Обновлнеие Параметров чтения файла */
    private function updateFileFlags()
    {
        $this->spl->setFlags(\SplFileObject::SKIP_EMPTY);
    }

    /** {@inheritDoc} */
    private function getFileName(bool $withExtension = true): string
    {
        $suffix = null;
        if ($withExtension) {
            $suffix = ".{$this->spl->getExtension()}";
        }

        return $this->spl->getBasename($suffix);
    }

    /** @return iterable Построчное чтение файла до конца файла */
    private function read(): iterable
    {
        while (!$this->spl->eof()) {
            yield $this->spl->fgetcsv();
        }
    }

    public function getData(): DataTransferInterface
    {
        $dto = new DataTransferObject();
        $data = [];
        foreach($this->read() as $line)
        {
            if ($line === null) {
                continue;
            }
            
            $data[] = $line;
            
        }
        // $dto->setHeads($data[0]);
        // unset($data[0]);
        $dto->setData($data);
        return $dto;
    }
}
