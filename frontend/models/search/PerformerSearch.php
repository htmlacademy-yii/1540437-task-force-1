<?php

namespace frontend\models\search;

use frontend\models\Performer;
use yii\data\ActiveDataProvider;
use yii\data\Sort;

class PerformerSearch extends Performer
{
    public $qname;

    private $_categoryIds = [];
    private $_isOnline = 0;
    private $_isFreeNow = 0;
    private $_isHasResponses = 0;
    private $_isFavorite = 0;

    public function getIsFavorite()
    {
        return \Yii::$app->session->get('_performer_filter.isfavorite', $this->_isFavorite);
    }

    public function setIsFavorite(string $value)
    {
        $this->_isFavorite = $value;
        \Yii::$app->session->set('_performer_filter.isfavorite', $value);
    }

    public function getCategoryIds()
    {
        $categoryIds = \Yii::$app->session->get('_performer_filter.categoryids', $this->_categoryIds);
        return \is_string($categoryIds) ? \unserialize($categoryIds) : [];
    }

    public function setCategoryIds($values)
    {
        if (!is_array($values)) {
            $values = [];
        }

        $this->_categoryIds = $values;
        \Yii::$app->session->set('_performer_filter.categoryids', \serialize($values));
    }

    /** @return bool */
    public function getIsOnline(): bool
    {
        return (bool) \Yii::$app->session->get('_performer_filter-isOnline', $this->_isOnline);
    }

    public function setIsOnline(string $value)
    {
        $this->_isOnline = (bool) $value;
        return \Yii::$app->session->set('_performer_filter-isOnline', $value);
    }

    /** @return bool */
    public function getIsFreeNow(): bool
    {
        return \Yii::$app->session->get('_performer_filter.isFreeNow', $this->_isFreeNow);
    }

    public function setIsFreeNow(string $value)
    {
        $this->_isFreeNow = $value;
        \Yii::$app->session->set('_performer_filter.isFreeNow', $value);
    }

    /** @return bool */
    public function getIsHasResponses()
    {
        return \Yii::$app->session->get('_performer_filter.isHasResponses', $this->_isHasResponses);
    }

    public function setIsHasResponses(string $value)
    {
        $this->_isHasResponses = $value;
        \Yii::$app->session->set('_performer_filter.isHasResponses', $value);
    }

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
        $this->load($params);

        $query = Performer::find();
        $query->joinWith([
            'profile p',
            'categories c' => function ($query) {
                if (!empty($this->categoryIds)) {
                    $query->andFilterWhere(['c.id' => $this->categoryIds]);
                    // $query->andFilterWhere(['c.id' => true]);
                }
            },
            'tasks t' => function ($query) {
                $query->done()->joinWith('userReviews ur');
            },
        ]);

        $query->select([
            'users.*',
            't.performer_user_id',
            'countTasks' => 'count(`t`.`id`)',
            'countReviews' => 'count(`ur`.`id`)',
            'avgRating' => 'avg(ur.rate)'
        ]);

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
                    'avgRating' => \SORT_DESC
                ]
            ],
        ]);

        $query->groupBy('users.id');

        if ($this->qname) {
            $query->andOnCondition(['like', 'users.name', $this->qname]);
            return new ActiveDataProvider([
                'query' => $query,
                'sort' => $sort,
                'pagination' => false
            ]);
        }

        if ($this->isHasResponses) {
            $query->andFilterHaving(['>', 'countReviews', 0]);
        }

        if ($this->isFreeNow) {
            $busyUsersQuery = \frontend\models\Task::find()->select('performer_user_id')->inProgress();
            $query->andFilterWhere(['not in', 'users.id', $busyUsersQuery]);
        }

        if ($this->isOnline) {
            $query->online();
        }

        if ($this->isFavorite) {
            $query->joinWith(['userFavorites uf']);
            $query->andFilterWhere(['uf.user_id' => \Yii::$app->user->id]);
        }

        return new ActiveDataProvider([
            'query' => $query,
            'sort' => $sort,
            'pagination' => [
                'pageSize' => \frontend\controllers\UserController::PAGE_SIZE
            ]
        ]);
    }
}
