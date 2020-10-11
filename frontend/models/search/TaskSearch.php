<?php

namespace frontend\models\search;

use frontend\models\Task;
use yii\data\ActiveDataProvider;
use yii\data\Sort;

class TaskSearch extends Task
{
    public $qname;

    /** @var array ID категорий для поиска */
    public $categoryIds;
    /** @var bool Сейчас свбоден */
    public $period = 'm';

    public $remoteWork;

    public $empty;

    /** {@inheritDoc} */
    public function attributeLabels()
    {
        $parent = parent::attributeLabels();
        $parent['period'] = \Yii::t('app', 'Период');
        $parent['qname'] = \Yii::t('app', 'Поиск по названию');
        $parent['remoteWork'] = \Yii::t('app', 'Удаленная работа');
        $parent['empty'] = \Yii::t('app', 'Без откликов');
        return $parent;
    }

    /** {@inheritDoc} */
    public function rules()
    {
        return [
            [['qname', 'period' ], 'safe'],
            [['categoryIds'], 'safe'],
            [['remoteWork', 'empty'], 'safe']
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
        $query = Task::find();

        $sort = new Sort([
            'attributes' => []
        ]);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => $sort,
            'pagination' => [
                'pageSize' => \frontend\controllers\TasksController::PAGE_SIZE
            ]
        ]);

        // $dataProvider->sort->defaultOrder = [
        //     'rtg' => [
        //         'avgRating' => SORT_DESC
        //     ]
        // ];

        if (!($this->load($params))) {
            return $dataProvider;
        }

        if ($this->qname) {
            $query->andFilterWhere(['like', 'title', $this->qname]);
        }

        return $dataProvider;
    }
}
