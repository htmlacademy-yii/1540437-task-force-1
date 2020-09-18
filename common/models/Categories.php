<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "categories".
 *
 * @property int $id
 * @property string $name
 * @property string|null $icon
 *
 * @property Tasks[] $tasks
 * @property UserCategories[] $userCategories
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

    /**
     * Gets query for [[Tasks]].
     *
     * @return \yii\db\ActiveQuery|\common\models\aq\TasksQuery
     */
    public function getTasks()
    {
        return $this->hasMany(Tasks::class, ['category_id' => 'id']);
    }

    /**
     * Gets query for [[UserCategories]].
     *
     * @return \yii\db\ActiveQuery|\common\models\aq\UserCategoriesQuery
     */
    public function getUserCategories()
    {
        return $this->hasMany(UserCategories::class, ['category_id' => 'id']);
    }

    /**
     * {@inheritdoc}
     * @return \common\models\aq\CategoriesQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \common\models\aq\CategoriesQuery(get_called_class());
    }
}
