<?php

namespace app\components;

use app\faker\AbstractFakeModel;
use Exception;

class SqlGenerator
{
    private $dbName;
    protected $_batchInsertTemplate = 'INSERT INTO `{db}`.`{table}` ({columns}) VALUES{n}{rows};';
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
     * Отключение проверки внених ключей Таблицы
     *
     * @return string
     */
    public function disbaleForeignKeyCheks():string
    {
        return 'SET FOREIGN_KEY_CHECKS = 0;' . PHP_EOL;
    }

    /**
     * Включение проверки внених ключей Таблицы
     *
     * @return string
     */
    public function enableForeignKeyCheks(): string
    {
        return 'SET FOREIGN_KEY_CHECKS = 1;' . PHP_EOL;
    }

    /**
     * Строка Очистки таблицы
     *
     * @param array $models Модель
     * @return string SQL строка
     */
    public function truncateByModel(array $models): string
    {
        $model = isset($models[0]) ? $models[0] : false;
        if (!($model instanceof AbstractFakeModel)) {
            throw new Exception('Массив моделей должен состоянть из `AbstractFakeModel` инстансов');
        }

        return strtr($this->_truncateTemplate, [
            '{db}' => $this->dbName,
            '{table}' => $model::tableName()
        ]) . PHP_EOL;
    }

    public function batchInsert(array $models): string
    {
        $columns = $rows = [];
        $i = 0;
        /** @var AbstractFakeModel $model */
        foreach ($models as $model) {
            $attributes = $model->getAttributes(true);
            if ($i === 0) {
                $columns = $this->getAttributeColumns($attributes);
                $tableName = $model::tableName();
            }
            $rows[] = $this->getAttributeRows($attributes);
            $i++;
        }

        $result = strtr($this->_batchInsertTemplate, [
            '{db}' => $this->dbName,
            '{n}' => "\n",
            '{table}' => $tableName,
            '{columns}' => $columns,
            '{rows}' => implode(",\n", $rows)
        ]);

        return $result . PHP_EOL;
    }

    /**
     * Получение строки по заданному шаблону.
     *
     * Шаблон пол умолчанию `{t}({rows})`
     *
     * @param array $attributes
     * @param string $template Шаблон для перобразования в строку
     * @return string
     */
    private function getAttributeRows(array $attributes, $template = '{t}({rows})'): string
    {
        $data = [];
        foreach ($attributes as $value) {
            $data[] = is_numeric($value) ? $value : "'{$value}'";
        }
        return strtr($template, ['{t}' => '  ', '{rows}' => implode(',', $data)]);
    }

    /**
     * Наименование Колонок
     *
     * @param array $attributes
     * @return string
     */
    private function getAttributeColumns(array $attributes): string
    {
        $data = [];
        foreach (array_keys($attributes) as $attr) {
            $data[] = "`{$attr}`";
        }
        return implode(',', $data);
    }
}
