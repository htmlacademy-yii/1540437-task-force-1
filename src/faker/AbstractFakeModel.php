<?php

namespace app\faker;

use app\components\CsvParser;

abstract class AbstractFakeModel
{
    public $id;
    protected $_insertTemplate = 'INSERT INTO `{db}`.`{table}` ({columns}) VALUE ({row});';
    protected $_updateTemplate = 'UPDATE `{db}`.`{table}` SET {data} WHERE id = {id}';
    protected $_truncateTemplate = 'TRUNCATE TABLE `{db}`.`{table}`';
    protected $_relations;


    /**
     * Конструктор класса
     *
     * @param integer $id
     * @param array|null $attributes
     */
    public function __construct(int $id, ?array $attributes = null)
    {
        $this->id = $id;
        $this->setAttributes($attributes);
    }

    /** {@inheritDoc} */
    public function __set(string $property, string $value)
    {
        $property = trim($property);
        $property = str_replace("_", "", $property);
        $propMethod = "set{$property}";
        
        if (method_exists($this, $propMethod)) {
            $this->$propMethod($value);
        } elseif (property_exists($this, $property)) {
            $ref = new \ReflectionProperty($this, $property);
            if ($ref->isPublic()) {
                // echo "Задали значение `{$value}` публичному свойству `{$property}`\n\n";
                $this->$property = $value;
            }
        } else {
            throw new \Exception("Свойство `{$property}` не определено или не Публичное в классе " . static::class);
        }
    }

    public function addRelation(string $relationName, Object $model)
    {
        $this->_relations[$relationName][] = $model;
    }

    /**
     * Публичные аттрибуты Класса и их значения.
     * [ propertyName -> propertyValue ]
     *
     * @param bool $skipEmpty
     * @return array
     */
    public function getAttributes(bool $skipEmpty = false): array
    {
        $reflect = new \ReflectionClass($this);
        $publicProps = $reflect->getProperties(\ReflectionProperty::IS_PUBLIC);

        $attributes = [];
        foreach ($publicProps as $prop) {
            if ($skipEmpty && !isset($this->{$prop->name})) {
                continue;
            }
            $attributes[$prop->name] = $this->{$prop->name};
        }
        return $attributes;
    }

    /**
     * Установка атрибутов
     *
     * @param array|null $attributes
     * @return void
     */
    public function setAttributes(?array $attributes)
    {
        if (!is_null($attributes)) {
            foreach ($attributes as $prop => $value) {
                $this->$prop = $value;
            }
        }
    }

    /**
     * Испорт данных из файла в Модели
     *
     * @param string|array $filename
     * @return array
     */
    public static function importFromFile(string $filename): array
    {
        $parser = new CsvParser($filename);
        $rows = $parser->getRows();

        $models = [];
        
        for ($i = 0; $i < count($rows); $i++) {
            $id = $i + 1;
            $class = static::className();
            $models[] = new $class($id, $rows[$i]);
        }

        return $models;
    }

    public function toSql(string $dbName, string $scenario = 'insert'):?string
    {
        $result = null;

        switch (strtolower($scenario)) {
            case 'insert':
                $attributes = $this->getAttributes(true);
                foreach ($attributes as $column => $row) {
                    $columns[] = "'{$column}'";
                    $data[] = is_numeric($row) ? $row : "\"{$row}\"";
                }
                $result = strtr($this->_insertTemplate, [
                    '{db}' => $dbName,
                    '{table}' => static::tableName(),
                    '{columns}' => implode(",", $columns),
                    '{row}' => implode(",", $data)
                ]);
                break;
            case 'update':
                $attributes = $this->getAttributes(true);
                $data = [];
                foreach ($attributes as $attribute => $value) {
                    if (isset($this->$attribute) && $attribute !== 'id') {
                        $data[] = "`{$attribute}`='{$value}'";
                    }
                }

                $result = strtr($this->_updateTemplate, [
                    '{id}' => $this->id,
                    '{db}' => $dbName,
                    '{table}' => static::tableName(),
                    '{data}' => implode(', ', $data)
                ]);
                break;
            case 'truncate':
                $result = strtr($this->_truncateTemplate, [
                    '{db}' => $dbName,
                    '{table}' => static::tableName()
                ]);
                break;
            default:
                throw new \Exception("Не известный сценарий: `{$scenario}`");
        }

        return $result;
    }

    public function exportToFile(string $fileName, string $dbName, string $scenario)
    {
        $parser = new CsvParser($fileName, 'w+');
        $data = $this->getAttributes(true);
    }

    /** @return string Имя класса */
    public static function className(): string
    {
        return static::class;
    }

    abstract protected static function tableName():string;
}
