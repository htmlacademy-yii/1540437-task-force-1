<?php
namespace app\components;

use app\exceptions\file\FileSeedException;

/**
 * @inheritDoc
 * @property array|null $_columns
 * @property string $parserClass Класс парсера, по умолчанию \SplFileObject
 */
class CsvParser extends AbstractFileParser
{
    /** @var SplFileObject $spl  */
    protected $spl;

    /** @var array|null */
    private $rows;

    /** {@inheritDoc} */
    protected function reset()
    {
        $this->spl->rewind();
    }

    /** {@inheritDoc} */
    protected function end()
    {
        if (!$this->spl->fseek(0, SEEK_END)) {
            throw new FileSeedException("Не удалось перейти в конеч строки");
        }
    }

    /** {@inheritDoc} */
    public function getNextLine(): ?iterable
    {
        $result = null;
        while (!$this->spl->eof()) {
            yield $this->spl->fgetcsv();
        }
        return null;
    }

    /**
     * Количество колонок
     *
     * @return int
     */
    public function getColumnCount(): int
    {
        return parent::getColumnCount();
    }

    public function getRows()
    {
        if (!isset($this->rows)) {
            foreach ($this->getRow() as $row) {
                if (is_array($row) && count($row)) {
                    $this->rows[] = $row;
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

    /**
     * Новая строка
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

    private function import()
    {
    }

    private function getResult()
    {
    }
}
