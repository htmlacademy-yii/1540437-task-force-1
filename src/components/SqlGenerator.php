<?php

namespace app\components;

use app\faker\AbstractFakeModel;

class SqlGenerator
{
    private $dbName;
    private $models;
    protected $_insertTemplate = 'INSERT INTO `{db}`.`{table}` ({columns}) VALUE ({row});';
    protected $_updateTemplate = 'UPDATE `{db}`.`{table}` SET {data} WHERE id = {id}';
    protected $_truncateTemplate = 'TRUNCATE TABLE `{db}`.`{table}`;';

    /**
     * SqlGenerator класс
     *
     * @param string $dbName
     */
    public function __construct(string $dbName)
    {
        $this->dbName = $dbName;
    }

    /**
     * Устанавливает Модель с данными для выполнения операций
     *
     * @param array $models
     * @return self
     */
    public function withModels(array $models): self
    {
        $this->models = $models;
        return $this;
    }

    /**
     * Генерирует SQL строки по всем Моделям
     *
     * @param boolean $truncateTable
     * @param string $scenario
     * @return string
     */
    public function generateSqlData(bool $truncateTable = true, string $scenario = 'insert'): string
    {
        $result = '';
        $i = 0;
        foreach ($this->models as $model) {
            if ($i == 0 && $truncateTable) {
                $result .= $this->generateSql($model, 'truncate') . PHP_EOL;
            }
            $i++;
            $result .= $this->generateSql($model, $scenario) . PHP_EOL;
        }
        $this->models = null;
        return $result;
    }

    /**
     * Генерация SQL синтаксиса на основе Модели данных AbstractFakeModel
     *
     * @param AbstractFakeModel $model
     * @param string $scenario
     * @return string|null
     */
    private function generateSql(AbstractFakeModel $model, string $scenario): ?string
    {
        $result = null;

        switch (strtolower($scenario)) {
            case 'insert':
                $attributes = $model->getAttributes(true);
                foreach ($attributes as $column => $row) {
                    $columns[] = "'{$column}'";
                    $data[] = is_numeric($row) ? $row : "\"{$row}\"";
                }
                $result = strtr($this->_insertTemplate, [
                    '{db}' => $this->dbName,
                    '{table}' => $model::tableName(),
                    '{columns}' => implode(',', $columns),
                    '{row}' => implode(',', $data)
                ]);
                break;
            case 'update':
                $attributes = $model->getAttributes(true);
                $data = [];
                foreach ($attributes as $attribute => $value) {
                    if (isset($this->$attribute) && $attribute !== 'id') {
                        $data[] = "`{$attribute}`='{$value}'";
                    }
                }

                $result = strtr($this->_updateTemplate, [
                    '{db}' => $this->dbName,
                    '{id}' => $model->id,
                    '{table}' => $model::tableName(),
                    '{data}' => implode(', ', $data)
                ]);
                break;
            case 'truncate':
                $result = strtr($this->_truncateTemplate, [
                    '{db}' => $this->dbName,
                    '{table}' => $model::tableName()
                ]);
                break;
            default:
                throw new \Exception("Не известный сценарий: `{$scenario}`");
        }

        return $result;
    }
}
