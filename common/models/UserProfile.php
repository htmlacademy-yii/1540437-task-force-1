<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "user_profile".
 *
 * @property int $id
 * @property string|null $about
 * @property string|null $birth_date
 * @property string|null $phone
 * @property string|null $skype
 * @property string|null $telegramm
 * @property string|null $avatar
 * @property int $views
 * @property string|null $address
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
            [['about'], 'string'],
            [['birth_date'], 'safe'],
            [['views'], 'integer'],
            [['phone', 'skype', 'telegramm', 'address'], 'string', 'max' => 90],
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
            'birth_date' => Yii::t('app', 'Birth Date'),
            'phone' => Yii::t('app', 'Phone'),
            'skype' => Yii::t('app', 'Skype'),
            'telegramm' => Yii::t('app', 'Telegramm'),
            'avatar' => Yii::t('app', 'Avatar'),
            'views' => Yii::t('app', 'Views'),
            'address' => Yii::t('app', 'Address'),
        ];
    }
}
