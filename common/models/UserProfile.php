<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "user_profile".
 *
 * @property int $id
 * @property string|null $about
 * @property string|null $first_name
 * @property string|null $last_name
 * @property string|null $gender
 * @property string|null $birth_date
 * @property string|null $phone
 * @property string|null $skype
 * @property string|null $telegramm
 * @property string|null $avatar
 * @property int $views
 *
 * @property Users[] $users
 */
class UserProfile extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'user_profile';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['about', 'gender'], 'string'],
            [['birth_date'], 'safe'],
            [['views'], 'integer'],
            [['first_name', 'last_name'], 'string', 'max' => 200],
            [['phone', 'skype', 'telegramm'], 'string', 'max' => 90],
            [['avatar'], 'string', 'max' => 45],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'about' => Yii::t('app', 'About'),
            'first_name' => Yii::t('app', 'First Name'),
            'last_name' => Yii::t('app', 'Last Name'),
            'gender' => Yii::t('app', 'Gender'),
            'birth_date' => Yii::t('app', 'Birth Date'),
            'phone' => Yii::t('app', 'Phone'),
            'skype' => Yii::t('app', 'Skype'),
            'telegramm' => Yii::t('app', 'Telegramm'),
            'avatar' => Yii::t('app', 'Avatar'),
            'views' => Yii::t('app', 'Views'),
        ];
    }

    /**
     * Gets query for [[Users]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUsers()
    {
        return $this->hasMany(Users::class, ['profile_id' => 'id'])->inverseOf('profile');
    }
}
