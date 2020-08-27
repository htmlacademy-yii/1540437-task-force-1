<?php

namespace app\faker;

use app\components\CsvParser;

abstract class AbstractFakeModel
{
    public $id;
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
        $property = str_replace('_', '', trim($property));
        $propMethod = "set{$property}";

        if (method_exists($this, $propMethod)) {
            $this->$propMethod($value);
        } elseif (property_exists($this, $property)) {
            $ref = new \ReflectionProperty($this, $property);
            if ($ref->isPublic()) {
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

    public function getRelations()
    {
        return $this->_relations;
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

    /** @return string Имя класса */
    public static function className(): string
    {
        return static::class;
    }

    abstract public static function tableName():string;
}
