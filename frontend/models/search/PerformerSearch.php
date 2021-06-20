<?php

namespace frontend\models\search;

use frontend\models\Performer;
use yii\data\ActiveDataProvider;
use yii\data\Sort;

class PerformerSearch extends Performer
{
    public $qname;

    /** @var array ID категорий для поиска */
    public $categoryIds;
    /** @var bool Сейчас свбоден */
    public $isFreeNow;
    /** @var bool Сейчас онлайн */
    public $isOnline;
    /** @var bool Есть отзывы */
    public $isHasResponses;
    /** @var bool В избранном */
    public $isFavorite;

    /** {@inheritDoc} */
    public function attributeLabels()
    {
        $parent = parent::attributeLabels();
        $parent['qname'] = \Yii::t('app', 'Поиск по имени');
        $parent['isFreeNow'] = \Yii::t('app', 'Сейчас свободен');
        $parent['isOnline'] = \Yii::t('app', 'Сейчас онлайн');
        $parent['isHasResponses'] = \Yii::t('app', 'Есть отзывы');
        $parent['isFavorite'] = \Yii::t('app', 'В избранном');
        return $parent;
    }

    /** {@inheritDoc} */
    public function rules()
    {
        return [
            [['qname', 'isFreeNow', 'isOnline', 'isHasResponses', 'isFavorite'], 'safe'],
            [['categoryIds'], 'safe'],
            [['avgRating', 'countResponses', 'fullName'], 'safe'],
            [['free', 'online', 'withResponses', 'favorites'], 'safe']
        ];
    }

    /**
     * Метод поиска
     *
     * @param array $params
     * @return ActiveDataProvider
     */
    public function search(array $params): ActiveDataProvider
    {
        $query = Performer::find();
        $query->with([
            'reviews',
            'responses'
        ]);

        $query->groupBy('users.id');

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => \frontend\controllers\UserController::PAGE_SIZE
            ]
        ]);
        
        if (!($this->load($params))) {
            return $dataProvider;
        }

        return $dataProvider;
    }
}
