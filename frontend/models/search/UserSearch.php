<?php

namespace frontend\models\search;

use frontend\models\User;
use yii\data\ActiveDataProvider;
use yii\data\Sort;
use yii\db\Expression;

class UserSearch extends User
{
    public $qname;

    public $avgRating;
    public $countTasks;
    public $countResponses;

    public $fullName;

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
            // [['courier', 'cargo', 'translation', 'construction', 'walking'], 'safe'],
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
        $query = User::find();
        $query->alias('u')
            ->select('u.*')
            ->joinWith(['categories c', 'taskResponses tr', 'performerTasks pt'])
            ->performers();

        $query->addSelect([
            'avgRating' => 'AVG(tr.`evaluation`)',
            'countResponses' => 'COUNT(tr.id)',
            'countTasks' => 'COUNT(pt.id)'
        ]);

        $query->addGroupBy(['u.id', 'tr.user_id']);

        $sort = new Sort([
            'attributes' => [
                'rtg' => [
                    'asc' => ['avgRating' => SORT_ASC],
                    'desc' => ['avgRating' => SORT_DESC],
                    'default' => SORT_DESC,
                    'label' => \Yii::t('app', 'Рейтингу')
                ],
                'tsc' => [
                    'asc' => ['countTasks' => SORT_ASC],
                    'desc' => ['countTasks' => SORT_DESC],
                    'default' => SORT_DESC,
                    'label' => \Yii::t('app', 'Числу заказов')
                ],
                'pop' => [
                    'asc' => ['countResponses' => SORT_ASC],
                    'desc' => ['countResponses' => SORT_DESC],
                    'default' => SORT_DESC,
                    'label' => 'Популярности'
                ],
            ]
        ]);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => $sort,
            'pagination' => [
                'pageSize' => \frontend\controllers\UsersController::PAGE_SIZE
            ]
        ]);

        $dataProvider->sort->defaultOrder = [
            'rtg' => [
                'avgRating' => SORT_DESC
            ]
        ];

        if (!($this->load($params))) {
            return $dataProvider;
        }

        if ($this->qname) {
            $query->filterWhere([
                'or',
                ['like', 'u.last_name', $this->qname],
                ['like', 'u.first_name', $this->qname]
            ]);
            return $dataProvider;
        }

        if (!empty($this->categoryIds)) {
            $query->andFilterWhere(['c.id' => $this->categoryIds]);
        }

        if ($this->isFreeNow) {
        }

        if ($this->isOnline) {
            $query->online();
        }

        if ($this->isHasResponses) {
        }

        if ($this->isFavorite) {
        }



        return $dataProvider;
    }
}
