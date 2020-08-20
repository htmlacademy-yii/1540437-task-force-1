<?php

namespace app\faker;

abstract class AbstractFakeModel
{
    public $id;

    public function __construct(int $id, ?array $attributes = null)
    {
        $this->id = $id;
        $this->setAttributes($attributes);
    }

    public function __set(string $property, string $value)
    {
        $propMethod = "set{$property}";
        if (method_exists($this, $propMethod)) {
            $this->$propMethod($value);
        } elseif (property_exists($this, $property)) {
            $ref = new \ReflectionProperty($this, $property);
            if ($ref->isPublic()) {
                $this->$property = $value;
            }
        } else {
            throw new \Exception("Свойство {$property} не определено");
        }
    }

    public function getAttributes()
    {
        $reflect = new \ReflectionClass($this);
        return $reflect->getProperties(\ReflectionProperty::IS_PUBLIC);
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
}
