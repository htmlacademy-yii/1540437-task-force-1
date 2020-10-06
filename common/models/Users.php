<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "users".
 *
 * @property int $id
 * @property int $city_id
 * @property string|null $about
 * @property int $role
 * @property string $first_name
 * @property string|null $last_name
 * @property string|null $gender
 * @property string $email
 * @property string|null $birth_date
 * @property string|null $avatar
 * @property string $password_hash
 * @property string|null $token
 * @property string|null $phone
 * @property string|null $skype
 * @property string|null $telegramm
 * @property int $failed_task_count
 * @property int $is_profile_public
 * @property int $is_contact_public
 * @property string $created_at
 * @property string|null $updated_at
 * @property string $last_logined_at
 *
 */
class Users extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'users';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['city_id', 'role', 'first_name', 'email', 'password_hash'], 'required'],
            [['city_id', 'role', 'failed_task_count', 'is_profile_public', 'is_contact_public'], 'integer'],
            [['about', 'gender'], 'string'],
            [['birth_date', 'created_at', 'updated_at', 'last_logined_at'], 'safe'],
            [['first_name', 'last_name', 'email'], 'string', 'max' => 245],
            [['avatar', 'phone', 'skype', 'telegramm'], 'string', 'max' => 128],
            [['password_hash', 'token'], 'string', 'max' => 256],
            [['email'], 'unique'],
            [['city_id'], 'exist', 'skipOnError' => true, 'targetClass' => Cities::class, 'targetAttribute' => ['city_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'city_id' => Yii::t('app', 'City ID'),
            'about' => Yii::t('app', 'About'),
            'role' => Yii::t('app', 'Role'),
            'first_name' => Yii::t('app', 'First Name'),
            'last_name' => Yii::t('app', 'Last Name'),
            'gender' => Yii::t('app', 'Gender'),
            'email' => Yii::t('app', 'Email'),
            'birth_date' => Yii::t('app', 'Birth Date'),
            'avatar' => Yii::t('app', 'Avatar'),
            'password_hash' => Yii::t('app', 'Password Hash'),
            'token' => Yii::t('app', 'Token'),
            'phone' => Yii::t('app', 'Phone'),
            'skype' => Yii::t('app', 'Skype'),
            'telegramm' => Yii::t('app', 'Telegramm'),
            'failed_task_count' => Yii::t('app', 'Failed Task Count'),
            'is_profile_public' => Yii::t('app', 'Is Profile Public'),
            'is_contact_public' => Yii::t('app', 'Is Contact Public'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
            'last_logined_at' => Yii::t('app', 'Last Logined At'),
        ];
    }
}
