<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "categories".
 *
 * @property int $id
 * @property string $name
 * @property string|null $icon
 */
class Categories extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'categories';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['name'], 'string', 'max' => 256],
            [['icon'], 'string', 'max' => 128],
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
            'icon' => Yii::t('app', 'Icon'),
        ];
    }
<<<<<<< HEAD

    /**
     * Gets query for [[Tasks]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getTasks()
    {
        return $this->hasMany(Tasks::class, ['category_id' => 'id'])->inverseOf('category');
    }

    /**
     * Gets query for [[UserCategories]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUserCategories()
    {
        return $this->hasMany(UserCategories::class, ['category_id' => 'id'])->inverseOf('category');
    }
=======
>>>>>>> 3bd84bf7b0f177b8b24981b055b0376d4831b0b3
}
