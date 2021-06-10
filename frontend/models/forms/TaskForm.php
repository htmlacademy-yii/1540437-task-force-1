<?php

namespace frontend\models\forms;

use \frontend\models\Task;
use yii\base\Model;

class TaskForm extends Model
{
    public $title;
    public $description;
    public $category;
    public $files;
    public $location;
    public $budget;
    public $expire;


    public function rules()
    {
        return [];
    }

    public function attributeLabels()
    {
        return [
            'title' => 'Мне нужно',
            'description' => 'Подробности задания',
            'category' => 'Категория',
            'files' => 'Файлы',
            'location' => 'Локация',
            'budget' => 'Бюджет',
            'expire' => 'Срок исполнения'
        ];
    }

    public function attributeHints()
    {
        return [
            'title' => 'Кратко опишите суть работы',
            'description' => 'Укажите все пожелания и детали, чтобы исполнителям было проще соориентироваться',
            'category' => 'Выберите категорию',
            'files' => 'Загрузите файлы, которые помогут исполнителю лучше выполнить или оценить работу',
            'location' => 'Укажите адрес исполнения, если задание требует присутствия',
            'budget' => 'Не заполняйте для оценки исполнителем',
            'expire' => 'Укажите крайний срок исполнения'
        ];
    }

    public function publish()
    {
    }
}
