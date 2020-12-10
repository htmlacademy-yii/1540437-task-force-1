<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "task_responses".
 *
 * @property int $id
 * @property int $task_id Задание
 * @property int $performer_user_id Исполнитель
 * @property float|null $amount Ваша цена
 * @property string|null $comment Комментарий
 * @property int|null $evaluation Оценка
 * @property string $created_at Создан
 * @property string|null $updated_at Отредактирован
 *
 * @property Task $task
 * @property User $performerUser
 */
class TaskResponse extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'task_responses';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['task_id', 'performer_user_id'], 'required'],
            [['task_id', 'performer_user_id', 'evaluation'], 'integer'],
            [['amount'], 'number'],
            [['comment'], 'string'],
            [['created_at', 'updated_at'], 'safe'],
            [['task_id'], 'exist', 'skipOnError' => true, 'targetClass' => Task::className(), 'targetAttribute' => ['task_id' => 'id']],
            [['performer_user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['performer_user_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'task_id' => Yii::t('app', 'Задание'),
            'performer_user_id' => Yii::t('app', 'Исполнитель'),
            'amount' => Yii::t('app', 'Ваша цена'),
            'comment' => Yii::t('app', 'Комментарий'),
            'evaluation' => Yii::t('app', 'Оценка'),
            'created_at' => Yii::t('app', 'Создан'),
            'updated_at' => Yii::t('app', 'Отредактирован'),
        ];
    }

    /**
     * Gets query for [[Task]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getTask()
    {
        return $this->hasOne(Task::className(), ['id' => 'task_id']);
    }

    /**
     * Gets query for [[PerformerUser]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPerformerUser()
    {
        return $this->hasOne(User::className(), ['id' => 'performer_user_id']);
    }
}
