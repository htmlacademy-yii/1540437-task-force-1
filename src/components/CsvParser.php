<?php

namespace app\components;

use app\exceptions\file\FileSeedException;

/**
 * @inheritDoc
 * @property string $parserClass Класс парсера, по умолчанию \SplFileObject
 */
class CsvParser extends AbstractFileParser
{
    /** @var \SplFileObject $spl  */
    protected $spl;

    /** @var array */
    private $rows = [];

    /** {@inheritDoc} */
    public function reset()
    {
        $this->spl->rewind();
    }

    /** {@inheritDoc} */
    public function end()
    {
        $this->spl->seek(PHP_INT_MAX);
        return $this->spl->key() + 1;
    }

    public function write(string $data)
    {
        $this->end();
        return $this->spl->fwrite($data);
    }

    /** {@inheritDoc} */
    public function getFirstLine(bool $saveCursor = true): ?string
    {
        return '';
    }

    /** {@inheritDoc} */
    public function getNextLine(): ?iterable
    {
        $result = null;
        while (!$this->spl->eof()) {
            yield $this->spl->fgetcsv();
        }
        return $result;
    }

    /**
     * Чтение новой строки
     *
     * @return iterable|null
     */
    public function getRow(): ?iterable
    {
        $result = null;
        while (!$this->spl->eof()) {
            yield $this->spl->fgetcsv();
        }
        return $result;
    }

    /**
     * Все колонки модели
     *
     * @return void
     */
    public function getRows()
    {
        if (empty($this->rows)) {
            foreach ($this->getNextLine() as $row) {
                if (is_array($row) && count($row) > 1) {
                    $data = array_combine($this->getColumns(), $row);
                    array_push($this->rows, $data);
                }
            }
        }
        return $this->rows;
    }

    protected function getHeader(): array
    {
        $this->reset();
        return $this->spl->fgetcsv();
    }
}
