<?php

namespace app\components\Convertor\Readers;

use app\components\Convertor\DbDataObject;
use app\components\Convertor\interfaces\DataTransferInterface;
use app\components\Convertor\Interfaces\ReaderInterface;

/** {@inheritDoc} */
class CsvReader extends AbstractFileReader implements ReaderInterface
{
    private $rows;
    private $columns;

    /** {@inheritDoc} */
    public function getSourceName(): string
    {
        return $this->getFileName(false);
    }

    /** {@inheritDoc} */
    public function setFile(string $fileName, string $fileMod = 'r')
    {
        $this->spl = new \SplFileObject($fileName, $fileMod);
    }

    /** @return \SplFileInfo */
    public function getFileInfo(): \SplFileInfo
    {
        return $this->getFile()->getFileInfo();
    }

    /** {@inheritDoc} */
    public function getFileName(bool $withExtension = true): string
    {
        $prefix = $this->getFileInfo()->getExtension();
        return $withExtension ? $this->getFileInfo()->getBasename() : $this->getFileInfo()->getBasename(".{$prefix}");
    }

    /** {@inheritDoc} */
    public function getFileExtension(): string
    {
        return $this->getFile()->getFileInfo()->getExtension();
    }

    /** {@inheritDoc} */
    public function getCurrentLine(): array
    {
        return $this->getFile()->fgetcsv();
    }

    /** {@inheritDoc} */
    public function getFirstLine(bool $saveCursor = true): ?array
    {
        $currentLine = $this->current();
        $this->reset();
        $result = $this->getCurrentLine();

        if ($saveCursor && is_numeric($currentLine)) {
            $this->moveTo($currentLine);
        }

        return $result;
    }

    /** {@inheritDoc} */
    public function getNextLine(): iterable
    {
        while (!$this->getFile()->eof()) {
            $line = $this->getCurrentLine();
            yield $line;
        }
    }

    /** {@inheritDoc} */
    public function getColumns(): array
    {
        if (!isset($this->columns)) {
            $this->columns = $this->getFirstLine();
        }

        return $this->columns;
    }

    /** {@inheritDoc}  */
    public function getRows(): array
    {
        if (!isset($this->rows)) {
            $columns = $this->getColumns();
            $this->reset();
            $this->getCurrentLine();

            /** @var array|null $line */
            foreach ($this->getNextLine() as $line) {
                if (count($columns) !== count($line)) {
                    continue;
                }
                $this->rows[] = $line;
            }
        }
        return $this->rows;
    }

    /** @return DataTransferInterface */
<<<<<<< HEAD
    public function getData(): DataTransferInterface
=======
    public function getDto(): DataTransferInterface
>>>>>>> 37da8738c7d731e74af13a60327ab798e30b20a8
    {
        $dto = new DbDataObject();
        $dto->setName($this->getFileName(false));
        $dto->setColumns($this->getColumns());
        $dto->setRows($this->getRows());

        return $dto;
    }
}
