<?php
namespace app\components;

use app\components\CsvParser;

class SqlGenerator
{
    private $dataBaseName;
    private $tableName;
    private $columns;
    private $rows;
    /** @var string */
    private $insertTemplate = 'INSERT INTO `{db}`.`{table}` ({columns}) VALUE ({row});';

    /**
     * SqlGenerator класс
     *
     * @param string $tableName
     * @param CsvParser $parser
     */
    public function __construct(string $tableName, CsvParser $parser)
    {
        list($this->dataBaseName, $this->tableName) = explode(".", $tableName, 2);
        $this->columns = $parser->getColumns();
    }

    public function truncate()
    {
        $name = implode('.', [$this->dataBaseName,$this->tableName]);
        return "TRUNCATE TABLE {$name};";
    }

    /**
     * Шаблон для генерации SQL строки
     *
     * @param string $tmpl
     * @return void
     */
    public function setTemplate(string $tmpl): void
    {
        $this->template = $tmpl;
    }
    
    public function getTableName(): string
    {
        return $this->tableName;
    }

    public function getColumns(): ?array
    {
        return $this->columns;
    }

    public function getRows(): ?array
    {
        return $this->rows;
    }

    public function generateSql()
    {
    }
}
