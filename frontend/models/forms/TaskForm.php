<?php

namespace frontend\models\forms;

use yii\base\Model;
use frontend\models\Task as TaskModel;
use app\bizzlogic\Task as TaskLogic;
use Yii;

/**
 * 
 * @property int $taskId
 */
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

    /** @var TaskModel $_taskModel */
    private $_taskModel;

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

    public function getTaskId()
    {
        return $this->getTaskModel()->id;
    }

    /**
     * Опубликовать задание
     * 
     * @return bool 
     */
    public function publish(): bool
    {
        $taskModel = $this->getTaskModel();

        if ($taskModel->user_id !== \Yii::$app->user->id) {
            throw new \yii\web\ForbiddenHttpException('Только владелец может публиковать задание');
        }

        try {
            $taskModel->status = \app\bizzlogic\Task::STATUS_NEW;
            $taskModel->published_at = new \yii\db\Expression('NOW()');
            $taskModel->save(false);
            return true;
        } catch (\Throwable $e) {

            return false;
        }
    }

    public function saveDraft(): bool
    {
        $taskModel = $this->getTaskModel();
        $taskModel->setAttributes($this->getAttributes());

        try {
            $taskModel->save(false);
            return true;
        } catch (\Throwable $e) {
            Yii::error($e->getMessage());
            // $this->addErrors($taskModel->getErrors());
            return false;
        }
    }

    public function loadDraft()
    {
        $this->setAttributes($this->getTaskModel()->getAttributes());
    }

    /**
     * Модель для Задания
     * 
     * @return TaskModel 
     */
    private function getTaskModel(): TaskModel
    {
        if (!$this->_taskModel) {
            $this->_taskModel = TaskModel::find()->user(\Yii::$app->user->id)->draft()->one();
        }

        if ($this->_taskModel === null) {
            $model = new TaskModel();
            $model->user_id = \Yii::$app->user->id;
            $model->status = TaskLogic::STATUS_NEW;
            $model->title = '';
            $model->description = '';
            $model->save(false);
            $this->_taskModel = $model;
        }

        return $this->_taskModel;
    }
}
