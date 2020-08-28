<?php

namespace app\components;

/**
 * @method array|null getColumns()
 */
abstract class AbstractFileParser
{
    /** @var \SplFileObject */
    protected $spl;

    /** @var array|null Колонки в файле */
    private $_columns = null;
    private $_curentCursor;
    private $_cursor;

    /**
     * AbstractFileParser function
     *
     * @param string $fileName
     * @param string $fileMod
     * @param boolean $parseColumns
     */
    public function __construct(string $fileName, string $fileMod = 'r', bool $parseColumns = true)
    {
        $this->spl = new \SplFileObject($fileName, $fileMod);
        if ($parseColumns) {
            $this->_columns = $this->getFirstLine(false);
        }
    }

    /** @return \SplFileObject */
    protected function getFile(): \SplFileObject
    {
        return $this->spl;
    }

    public function getFileInfo()
    {
        return $this->getFile()->getFileInfo();
    }

    /** Установить курсор в начало строки {@return void} */
    protected function cursorReset(): void
    {
        $this->getFile()->rewind();
    }

    protected function cursorNext()
    {
        $this->getFile()->next();
    }

    /** Установить курсор в конец строки */
    abstract protected function end();

    /** Сохранить текущий указатель строки */
    abstract protected function current();

    /**
     * Считать первую строку файла.
     * Если сохраняем указатель, то после прочтения первой строки,
     * возвращаем указатель на свое место, в противном случаи
     * смещаемся на следующую строку.
     *
     * @param bool $backToCurrentCursor
     * @return string|null  */
    abstract public function getFirstLine(bool $backToCurrentCursor = true): ?string;

    /** @return string|null Текущую строку */
    abstract public function getCurrentLine(): ?string;

    /**
     * Читаем фаил до конца строки.
     *
     * @return iterable|null
     */
    abstract public function getNextLine(): ?iterable;
}
