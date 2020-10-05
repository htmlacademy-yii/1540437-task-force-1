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
        $query->alias('u')
            ->select('u.*')
            ->joinWith(['categories c', 'taskResponses tr'])
            ->with(['performerTasks'])
            ->performers();

        $query->addSelect([
            'avgRating' => 'AVG(tr.`evaluation`)',
            'countResponses' => 'COUNT(`tr`.`id`)'
        ]);

        $query->addGroupBy(['u.id', 'tr.user_id']);

        $sort = new Sort([
            'attributes' => [
                'rtg' => [
                    'asc'  => [ 'avgRating' => SORT_ASC ],
                    'desc' => [ 'avgRating' => SORT_DESC ],
                    'label' => \Yii::t('app', 'Рейтингу')
                ],
                'tsc' => [
                    'asc' => [ 'countResponses' => SORT_ASC ],
                    'desc' => [ 'countResponses' => SORT_DESC ],
                    'label' => \Yii::t('app', 'Числу заказов')
                ],
                // 'pop' => [
                //     'label' => 'Популярности'
                // ],
            ]
        ]);


        // $sort->defaultOrder = [
        //     'avgRating' => SORT_ASC
        // ];


        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => $sort
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
