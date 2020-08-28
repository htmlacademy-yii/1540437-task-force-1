<?php

namespace app\faker;

class FakeModels
{
    public $id;
    public $name;
    public $icon;

    private $attributes;
    private $tableName = 'categories';
    private $models;

    public function attributes()
    {
        return [
            'id' => 'auto_increment',
            'name' => 'name',
            'icon' => 'icon'
        ];
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

    public function importFromFile(string $filename, array $attributes)
    {
        $file = new \SplFileObject($filename);
        while (!$file->eof()) {
            $this->models[] = $file->fgetcsv();
        }
    }
}
