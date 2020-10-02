<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "user_attachments".
 *
 * @property int $id
 * @property int $user_id
 * @property int|null $task_id
 * @property string $display_name
 * @property string $file_name
 * @property string|null $file_path
 * @property string|null $file_meta
 * @property string|null $thumb_path
 *
 * @property Users $user
 * @property Tasks $task
 */
class UserAttachments extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'user_attachments';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id', 'display_name', 'file_name'], 'required'],
            [['user_id', 'task_id'], 'integer'],
            [['file_name', 'file_path', 'file_meta', 'thumb_path'], 'string'],
            [['display_name'], 'string', 'max' => 256],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['user_id' => 'id']],
            [['task_id'], 'exist', 'skipOnError' => true, 'targetClass' => Tasks::className(), 'targetAttribute' => ['task_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'user_id' => Yii::t('app', 'User ID'),
            'task_id' => Yii::t('app', 'Task ID'),
            'display_name' => Yii::t('app', 'Display Name'),
            'file_name' => Yii::t('app', 'File Name'),
            'file_path' => Yii::t('app', 'File Path'),
            'file_meta' => Yii::t('app', 'File Meta'),
            'thumb_path' => Yii::t('app', 'Thumb Path'),
        ];
    }

    /**
     * Gets query for [[User]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(Users::className(), ['id' => 'user_id'])->inverseOf('userAttachments');
    }

    /**
     * Gets query for [[Task]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getTask()
    {
        return $this->hasOne(Tasks::className(), ['id' => 'task_id'])->inverseOf('userAttachments');
    }
}
