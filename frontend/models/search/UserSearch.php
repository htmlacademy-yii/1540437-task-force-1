<?php

namespace frontend\models\search;

use frontend\models\User;
use yii\data\ActiveDataProvider;
use yii\data\Sort;

class UserSearch extends User
{
    /**  */
    public $q;

    public $avgRating;
    public $countTasks;
    public $countResponses;

    public $fullName;

    /** @var array ID категорий для поиска */
    public $categoryIds;

    public $free;
    public $online;
    public $withResponses;
    public $favorites;

    public function attributeLabels()
    {
        $parent = parent::attributeLabels();
        $parent['q'] = \Yii::t('app', 'Поиск по имени');
        return $parent;
    }

    /** {@inheritDoc} */
    public function rules()
    {
        return [
            [['q'], 'safe'],
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
        $query
            ->alias('u')
            ->select('u.*')
            ->joinWith(['categories c', 'taskResponses tr', 'performerTasks pt'])
            // ->with(['performerTasks'])
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
                'pageSize' => \frontend\controllers\UsersController::PAGE_LIMIT
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

        if (!empty($this->categoryIds)) {
            $query->andFilterWhere(['c.id' => $this->categoryIds]);
        }

        if ($this->q) {
            $query->andFilterWhere(['like', 'u.first_name', $this->q]);
        }

        return $dataProvider;
    }
}
