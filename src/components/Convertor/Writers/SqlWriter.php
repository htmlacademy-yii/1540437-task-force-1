<?php

namespace app\components\Convertor\Writers;

use app\components\Convertor\interfaces\DataTransferInterface;
use app\components\Convertor\Interfaces\WriterInterface;

class SqlWriter implements WriterInterface
{
    /** @var string Путь до каталога */
    private $path;

    /** @var string Название базы данных */
    private $dbName = 'taskforce';

    /** @var DataTransferInterface $dataObject */
    private $dataObject;

    /** @var string $_batchInsertTemplate Шаблон для преобразования */
    protected $_batchInsertTemplate = 'INSERT INTO `{db}`.`{table}` ({columns}) VALUES{n}{rows};';

    /** {@inheritDoc} */
    public function setData(DataTransferInterface $dataObject): void
    {
        $this->dataObject = $dataObject;
    }

    /** @return string Имя файла с расширением .sql */
    public function getFileName(): string
    {
        return $this->dataObject->getName() . '.sql';
    }

    /** @return string Путь до коталога */
    public function getPath(): string
    {
        return $this->path;
    }

    public function setPath(string $path): void
    {
        $this->path = $path;
    }

    /** {@inheritDoc} */
    public function generate(): string
    {
        foreach ($this->dataObject->getRows() as $row) {
            $rows[] = self::templatedRows($row);
        }

        return strtr($this->_batchInsertTemplate, [
            '{db}' => $this->dbName,
            '{n}' => "\n",
            '{table}' => $this->dataObject->getName(),
            '{columns}' => self::templatedColumns($this->dataObject->getColumns()),
            '{rows}' => implode(",\n", $rows)
        ]) . PHP_EOL;
    }

    /** {@inheritDoc} */
    public function saveAsFile(string $data): int
    {
        $filename = "{$this->getPath()}/{$this->getFileName()}";
        $file = new \SplFileObject($filename, 'w+');
        $file->ftruncate(0);
        return $file->fwrite($data);
    }

    /**
     * Получение строки по заданному шаблону.
     *
     * Шаблон пол умолчанию `{spaces}({rows})`
     *
     * @param array $rows
     * @param string $template Шаблон для перобразования в строку
     * @return string
     */
<<<<<<< HEAD
    private static function templatedRows(array $rows, $template = '{spaces}({rows})'): string
=======
    private static function templatedRows(array $rows, $template = '{t}({rows})'): string
>>>>>>> 37da8738c7d731e74af13a60327ab798e30b20a8
    {
        $data = [];
        foreach ($rows as $value) {
            $_data = is_numeric($value) ? $value : "'{$value}'";
            $_data = str_replace("\n", '\n', $_data);
            $data[] = $_data;
        }
        return strtr($template, ['{spaces}' => '  ', '{rows}' => implode(',', $data)]);
    }

    /**
    * Наименование Колонок
    *
    * @param array $attributes
    * @return string
    */
    private static function templatedColumns(array $columns): string
    {
        $data = [];
        foreach ($columns as $column) {
            $data[] = "`{$column}`";
        }
        
        return implode(',', $data);
    }
}
