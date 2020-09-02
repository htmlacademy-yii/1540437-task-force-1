<?php

namespace app\components;

/**
 * Парсер файлов CSV
 *
 * {@inheritDoc}
 */
class CsvParser extends AbstractFileWrapper
{
    /** @var array Массив строк файла */
    private $rows = [];

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
            yield $this->getFile()->fgetcsv();
        }
    }

    /** {@inheritDoc} */
    public function getCurrentLine(): array
    {
        return $this->getFile()->fgetcsv();
    }

    /** @return array Все строки модели */
    public function getRows(): array
    {
        if (empty($this->rows)) {
            $columns = $this->getColumns();
            foreach ($this->getNextLine() as $row) {
                if ($row[0] === null) {
                    continue;
                }
                array_push($this->rows, array_combine($columns, $row));
            }
        }

        return $this->rows;
    }

    /** @return array Массив значений первой строки файла */
    protected function getColumns()
    {
        return array_values($this->getFirstLine(false));
    }
}
