<?php

namespace app\components\Convertor\Writers;

use app\components\Convertor\interfaces\DataTransferInterface;
use app\components\Convertor\Interfaces\WriterInterface;

class SqlWriter implements WriterInterface
{
    /** @var string Название базы данных */
    public $dbName = 'taskforce';

    /** @var string Путь до каталога */
    private $path;

    /** @var DataTransferInterface $dataObject */
    private $dataObject;

    /** @var string $_batchInsertTemplate Шаблон для преобразования */
    private $_batchInsertTemplate = 'INSERT INTO `{db}`.`{table}` ({columns}) VALUES{n}{rows};';

    /** {@inheritDoc} */
    public function withData(DataTransferInterface $dataObject): self
    {
        $this->dataObject = $dataObject;
        return $this;
    }

    /** @return string Имя файла с расширением .sql */
    private function getFileName(): string
    {
        return $this->dataObject->getName() . '.sql';
    }

    /** @return string Путь до коталога */
    private function getPath(): string
    {
        return $this->path;
    }

    /** @param string $path Путь до каталога с файлами */
    public function setPath(string $path): void
    {
        $this->path = $path;
    }

    /** Преобразованиме Данных в строку SQL формата */
    private function toString(): string
    {
        return strtr($this->_batchInsertTemplate, [
            '{db}' => $this->dbName,
            '{n}' => "\n",
            '{table}' => $this->dataObject->getName(),
            '{columns}' => self::templatedColumns($this->dataObject->getHeads()),
            '{rows}' => self::templatedRows($this->dataObject->getData())
        ]) . PHP_EOL;

        return $this;
    }

    /** {@inheritDoc} */
    public function save(): int
    {
        $filename = "{$this->getPath()}/{$this->getFileName()}";
        $file = new \SplFileObject($filename, 'w+');
        $file->ftruncate(0);
        return $file->fwrite($this->toString());
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
    private static function templatedRows(array $rows, $template = '{spaces}({rows})'): string
    {
        $result = [];

        foreach ($rows as $row) {
            $result[] = strtr($template, [
                '{spaces}' => '  ',
                '{rows}' => self::rowValues($row)
            ]);
        }

        return implode(",\n", $result);
    }

    /**
     * Значения строк данных
     *
     * @param array $row
     * @return string
     */
    private static function rowValues(array $row): string
    {
        $values = [];
        foreach ($row as $value) {
            $_data = is_numeric($value) ? $value : "'{$value}'";
            $values[] = str_replace("\n", '\n', $_data);
        }

        return implode(',', $values);
    }

    /**
    * Наименование Колонок
    *
    * @param array $headers
    * @return string
    */
    private static function templatedColumns(array $headers, $template = '`{header}`'): string
    {
        $data = [];
        foreach ($headers as $header) {
            $data[] = strtr($template, ['{header}' => $header]);
        }
        return implode(',', $data);
    }
}
