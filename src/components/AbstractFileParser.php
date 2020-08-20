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
     * Конструктор класса
     *
     * @param string $fileName Полный путь до файла
     */
    public function __construct(string $fileName)
    {
        $this->spl = new $this->parserClass($fileName);
        $this->_columns = $this->getHeader();
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
