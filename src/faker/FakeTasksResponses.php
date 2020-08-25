<?php

namespace app\faker;

class FakeTasksResponses extends AbstractFakeModel
{
    public $id;
    public $task_id;
    public $user_id;
    public $price;
    public $comment;
    public $rate;
    public $is_success;
    public $created_at;
    public $updated_at;

    public static function tableName(): string
    {
        return 'task_responses';
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
