<?php

namespace app\faker;

class FakeTasks extends AbstractFakeModel
{
    public $id;
    public $customer_user_id;
    public $performer_user_id;
    public $category_id;
    public $city_id;
    public $title;
    public $description;
    public $address;
    public $budget;
    public $created_at;
    public $updated_at;
    public $start_date;
    public $lattitude;
    public $longtitude;

    public static function tableName(): string
    {
        return 'tasks';
    }

    public function setName($val)
    {
        $this->title = $val;
    }

    public function setCategory($val)
    {
        $this->category_id = intval($val);
    }

    public function setCreated($value)
    {
        $this->created_at = date('Y-m-d H:i:s', strtotime($value));
    }

    public function setExpire($value)
    {
        $this->start_date = date('Y-m-d H:i:s', strtotime($value));
    }

    public function setDesc(string $value)
    {
        $this->description = str_replace("\n", '\n', $value);
    }
}
