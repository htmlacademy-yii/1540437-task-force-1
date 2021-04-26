<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "user_notifications".
 *
 * @property int $id
 * @property int $user_id
 * @property int $new_message
 * @property int $new_respond
 * @property int $task_actions
 *
 * @property User $user
 */
class UserNotification extends \common\models\UserNotification
{
    /**
     * Gets query for [[User]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::class, ['id' => 'user_id']);
    }
}
