<?php
namespace app\faker;

class FakeProfile extends AbstractFakeModel
{
    public $address;
    public $birth_date;
    public $about;
    public $phone;
    public $skype;

    protected static function tableName(): string
    {
        return 'users';
    }
}
