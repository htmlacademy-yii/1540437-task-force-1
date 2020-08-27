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

    public function importFromFile(string $filename, array $attributes)
    {
        $file = new \SplFileObject($filename);
        while (!$file->eof()) {
            $line = $file->fgetcsv();
        }
    }
}
