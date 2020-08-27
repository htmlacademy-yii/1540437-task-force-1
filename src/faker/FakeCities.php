<?php

namespace app\faker;

class FakeCities extends AbstractFakeModel
{
    public $id;
    public $name;
    public $lattitude;
    public $longtitude;

    public static function tableName(): string
    {
        return 'cities';
    }

    public function setCity(string $val)
    {
        $this->name = $val;
    }

    public function setLat(string $val)
    {
        $this->lattitude = (float) $val;
    }

    public function setLong(string $val)
    {
        $this->longtitude = (float) $val;
    }
}
