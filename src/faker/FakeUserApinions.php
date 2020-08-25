<?php

namespace app\faker;

class FakeUserApinions extends AbstractFakeModel
{
    public $id;
    public $user_id;
    public $refer_task_id;
    public $comment;
    public $rate;
    public $created_at;

    public static function tableName(): string
    {
        return 'user_opinions';
    }

    public function setDtAdd($value)
    {
        $this->created_at = date('Y-m-d H:i:s', strtotime($value));
    }

    public function setDescription($value)
    {
        $this->comment = str_replace("\n", '\n', $value);
    }
}
