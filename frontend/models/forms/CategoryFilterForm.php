<?php

namespace frontend\models\forms;

use Yii;

class CategoryFilterForm extends \yii\base\Model
{
    public $courier = true;
    public $cargo;
    public $translation;
    public $construction;
    public $walking;

    public $free;
    public $online;
    public $withResponses;
    public $favorites;

    /** {@inheritDoc} */
    public function rules()
    {
        return [
            [['courier', 'cargo', 'translation', 'construction', 'walking'], 'safe'],
            [['free', 'online', 'withResponses', 'favorites'], 'safe']
        ];
    }

    /**
     * Фильтры для сортировки, по порядку.
     * Legend => [ ... attributes ]
     *
     * @return array 
     */
    public function fieldsets(): array
    {
        return [
            Yii::t('app', 'Категории') => [
                'courier', 'cargo', 'translation', 'construction', 'walking'
            ],
            Yii::t('app', 'Дополнительно') => [
                'free', 'online', 'withResponses', 'favorites'
            ],
        ];
    }

    public function attributeLabels()
    {
        return [
            /** Категории */
            'courier' => Yii::t('app', 'Курьерские услуги'),
            'cargo' => Yii::t('app', 'Грузоперевозки'),
            'translation' => Yii::t('app', 'Переводы'),
            'construction' => Yii::t('app', 'Переводы'),
            'walking' => Yii::t('app', 'Выгул животных'),
            /** Допоолнительные поля */
            'free' => Yii::t('app', 'Сейчас свободен'),
            'online' => Yii::t('app', 'Сейчас онлайн'),
            'withResponses' => Yii::t('app', 'Есть отзывы'),
            'favorites' => Yii::t('app', 'В избранном')
        ];
    }
}
