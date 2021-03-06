<?php

namespace app\components\Convertor\Readers;

use app\components\Convertor\DataTransferObject;
use app\components\Convertor\interfaces\DataTransferInterface;
use app\components\Convertor\Interfaces\ReaderInterface;
use app\exceptions\converter\ConverterReaderException;
use SplFileObject;

/** {@inheritDoc} */
class CsvReader implements ReaderInterface
{
    /** @var \SplFileObject $spl */
    private $spl;

    /** @var string Фаил для чтения */
    private $file;

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
    public function setFile(string $fileName)
    {
        $this->file = $fileName;
    }

    /**
     * Имя файла, с расширением или без
     *
     * @param boolean $withExtension По умолчанию `true`
     * @return string
     */
    private function getFileName(bool $withExtension = true): string
    {
        $suffix = null;
        if (!$withExtension) {
            $suffix = ".{$this->getSpl()->getExtension()}";
        }

        return $this->getSpl()->getBasename($suffix);
    }

    /**
     * @return SplFileObject $spl
     * @throws ConverterReaderException Если перед вызовом метода не установили фаил для чтения.
     */
    private function getSpl(): SplFileObject
    {
        if (!isset($this->spl)) {
            if (!isset($this->file)) {
                throw new ConverterReaderException('Перед использование метода необходимо указать фаил для чтения.');
            }

            $this->spl = new SplFileObject($this->file);
            $this->spl->setFlags(
                SplFileObject::READ_CSV |
                SplFileObject::SKIP_EMPTY |
                SplFileObject::READ_AHEAD |
                SplFileObject::DROP_NEW_LINE
            );
        }

        return $this->spl;
    }

    /** {@inheritDoc} */
    public function getData(): DataTransferInterface
    {
        $spl = $this->getSpl();
        $dto = new DataTransferObject();
        $dto->setName($this->getFileName(false));
        $dto->setHeads($spl->current());

        $data = [];

        while (!$spl->eof()) {
            if ($csvData = $spl->fgetcsv()) {
                $data[] = $csvData;
            }
        }

        $dto->setData($data);
        return $dto;
    }
}
