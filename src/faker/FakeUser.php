<?php

namespace app\faker;

class FakeUser extends AbstractFakeModel
{
    public $id;
    public $about;
    public $email;
    public $address;
    public $first_name;
    public $last_name;
    public $birth_date;
    public $password_hash;
    public $phone;
    public $skype;
    public $telegramm;
    public $created_at;

    protected static function tableName(): string
    {
        return 'users';
    }

    public function setName(string $name)
    {
        list($this->first_name, $this->last_name) = explode(' ', $name);
    }

    public function setPassword(string $password)
    {
        $this->password_hash = hash('md5', $password);
    }

    public function setTmail(string $email)
    {
        $this->email = $email;
        list($tag) = explode('@', $email, 2);
        $this->telegramm = "@{$tag}";
    }
}
