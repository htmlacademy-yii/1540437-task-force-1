<?php

namespace app\faker;

class FakeProfile extends AbstractFakeModel
{
    public $address;
    public $birth_date;
    public $about;
    public $phone;
    public $skype;

    public static function tableName(): string
    {
        return 'users';
    }
}
