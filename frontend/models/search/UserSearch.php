<?php

namespace frontend\models\search;

use frontend\models\User;
use yii\data\ActiveDataProvider;
use yii\data\Sort;

class UserSearch extends User
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
        $query = User::find();
        $query->alias('u')
            ->select('u.*')
            // ->with(['categories'])
            ->joinWith([
                'customerTasks t',
                'profile p',
                'categories c',
                'responses tr',
                'userReviews ur'
            ]);

        // $query->andFilterWhere();


        $query->addSelect([
            'avgRating' => 'AVG(`ur`.`rate`)',
            'countResponses' => 'COUNT(DISTINCT tr.id)',
            'countTasks' => 'COUNT(DISTINCT `t`.`id`)'
        ]);

        $query->addGroupBy(['u.id']);

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
                    'asc' => ['p.views' => SORT_ASC],
                    'desc' => ['p.views' => SORT_DESC],
                    'default' => SORT_DESC,
                    'label' => \Yii::t('app', 'Популярности')
                ],
            ],
            'defaultOrder' => [
                'rtg' => [
                    'avgRating' => SORT_DESC
                ]
            ],
        ]);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => $sort,
            'pagination' => [
                'pageSize' => \frontend\controllers\UserController::PAGE_SIZE
            ]
        ]);

        if (!($this->load($params))) {
            return $dataProvider;
        }

        if ($this->qname) {
            $query->andOnCondition(['like', 'u.name', $this->qname]);
            return $dataProvider;
        }

        if (!empty($this->categoryIds)) {
            $query->andFilterWhere(['c.id' => $this->categoryIds]);
        }

        if ($this->isFreeNow) {
            $busyUsersQuery = \frontend\models\Task::find()->select('performer_user_id')->inProgress();
            $query->andFilterWhere(['not in', 'u.id', $busyUsersQuery]);
        }

        if ($this->isOnline) {
            $query->online();
        }

        if ($this->isHasResponses) {
            $query->addSelect(['cntReviews' => 'count(DISTINCT ur.id)']);
            $query->andFilterHaving(['>', 'cntReviews', 0]);
        }

        if ($this->isFavorite) {
            // $query->joinWith(['userFavorites uf']);
            // $query->andFilterWhere(['uf.user_id' => \Yii::$app->user->id]);
        }

        return $dataProvider;
    }
}
