<?php

namespace frontend\models\forms;

use yii\base\Model;
use frontend\models\Task as TaskModel;
use app\bizzlogic\Task as TaskLogic;

class TaskForm extends Model
{
    public $id;
    public $title;
    public $description;
    public $category;
    public $location;
    public $budget;
    public $expire;
    public $status;

    private $_relatedId;

    public function rules()
    {
        return [
            [['title', 'description', 'category'], 'required', 'message' => 'Обязательное к заполнению поле'],
            [['title', 'description'], 'trim'],
            ['title', 'string', 'min' => 10],
            ['description', 'string', 'min' => 30],
            [['category'], 'required', 'message' => 'Это поле должно быть выбрано'],
            [
                'category', 'exist', 'skipOnError' => false,
                'targetClass' => \common\models\Category::class, 'targetAttribute' => ['category' => 'id'],
                'message' => 'Задание должно принадлежать одной из категорий'
            ],
            [['budget'], 'compare', 'compareValue' => 0, 'operator' => '>', 'type' => 'number', 'skipOnEmpty' => true],
            [['expire', 'status'], 'safe'],
            [['title'], 'string', 'max' => 256]
        ];
    }

    public function setCategory(string $value)
    {
        $this->category_id = $value;
    }

    public function getCategory()
    {
        return $this->category_id;
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

    public function publish(): ?int
    {
        $model = new \frontend\models\Task();
        $model->user_id = \Yii::$app->user->id;
        $model->category_id = $this->category;
        $model->title = $this->title;
        $model->description = $this->description;
        $model->status = \app\bizzlogic\Task::STATUS_NEW;

        if (isset($this->budget)) {
            $model->budget = $this->budget;
        }

        if (isset($this->expire)) {
            $model->expire = $this->expire;
        }

        return $model->save() ? $model->id : null;
    }

    public static function draftModel(): self
    {
        $form = new static;

        $model = TaskModel::find()
            ->user(\Yii::$app->user->id)
            ->draft()
            ->one();

        if ($model === null) {
            $model = new TaskModel();
            $model->user_id = \Yii::$app->user->id;
            $model->status = TaskLogic::STATUS_DRAFT;
            $model->title = '';
            $model->description = '';
            $model->save(false);
        }

        $form->setAttributes($model->getAttributes(), ['id', 'category_id']);
        $form->category = $model->category_id;
        $form->id = $model->id;

        return $form;
    }
}
