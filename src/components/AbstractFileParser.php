<?php
namespace app\components;

/**
 * Undocumented class
 *
 * @method array|null getColumns()
 */
abstract class AbstractFileParser
{
    private $_columns = null;
    protected $parserClass = '\SplFileObject';
    protected $spl;

    /**
     * Undocumented function
     *
     * @param string $fileName
     * @param string $fileMod
     * @param boolean $parseColumns
     */
    public function __construct(string $fileName, string $fileMod = 'r', bool $parseColumns = true)
    {
        $this->spl = new $this->parserClass($fileName, $fileMod);
        if ($parseColumns) {
            $this->_columns = $this->getHeader();
        }
    }

    /**
     * Колонки
     *
     * @return array
     */
    public function getColumns(): ?array
    {
        return $this->_columns;
    }

    /**
     * Количество колонок в файле
     *
     * @return int
     */
    protected function getColumnCount(): int
    {
        return is_null($this->_columns) ? 0 : count($this->_columns);
    }

    /** Установить курсор в начало строки */
    abstract protected function reset();
    /** Установить курсор в конец строки  */
    abstract protected function end();
    /** Считать первую строку */
    abstract protected function getHeader(): array;
    
    /**
     * Чтение файла, до конца строки
     *
     * @return iterable|null
     */
    abstract public function getNextLine(): ?iterable;
}
