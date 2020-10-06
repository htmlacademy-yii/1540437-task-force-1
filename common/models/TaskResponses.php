<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "task_responses".
 *
 * @property int $id
 * @property int $task_id
 * @property int $user_id
 * @property float|null $price
 * @property string|null $comment
 * @property int|null $evaluation
 * @property int|null $is_success
 * @property string $created_at
 * @property string|null $updated_at
 */
class TaskResponses extends \yii\db\ActiveRecord
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
            [['task_id', 'user_id'], 'required'],
            [['task_id', 'user_id', 'evaluation', 'is_success'], 'integer'],
            [['price'], 'number'],
            [['comment'], 'string'],
            [['created_at', 'updated_at'], 'safe'],
            [['task_id'], 'exist', 'skipOnError' => true, 'targetClass' => Tasks::class, 'targetAttribute' => ['task_id' => 'id']],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => Users::class, 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'task_id' => Yii::t('app', 'Task ID'),
            'user_id' => Yii::t('app', 'User ID'),
            'price' => Yii::t('app', 'Price'),
            'comment' => Yii::t('app', 'Comment'),
            'evaluation' => Yii::t('app', 'Evaluation'),
            'is_success' => Yii::t('app', 'Is Success'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
        ];
    }
}
