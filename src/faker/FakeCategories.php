<?php
namespace app\faker;

class FakeCategories extends AbstractFakeModel
{
    public $id;
    public $name;
    public $icon;

    protected static function tableName(): string
    {
        return 'categories';
    }
}
