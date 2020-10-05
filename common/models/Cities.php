<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "cities".
 *
 * @property int $id
 * @property string|null $name
 * @property float|null $lattitude
 * @property float|null $longtitude
<<<<<<< HEAD
 *
 * @property Tasks[] $tasks
 * @property Users[] $users
=======
>>>>>>> 3bd84bf7b0f177b8b24981b055b0376d4831b0b3
 */
class Cities extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'cities';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['lattitude', 'longtitude'], 'number'],
            [['name'], 'string', 'max' => 256],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'name' => Yii::t('app', 'Name'),
            'lattitude' => Yii::t('app', 'Lattitude'),
            'longtitude' => Yii::t('app', 'Longtitude'),
        ];
    }
}
