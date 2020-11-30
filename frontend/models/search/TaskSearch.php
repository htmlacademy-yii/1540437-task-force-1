<?php

namespace frontend\models\search;

use DateTime;
use frontend\models\Task;
use yii\data\ActiveDataProvider;

class TaskSearch extends Task
{
    /** @var string Поиск по названию */
    public $searchByName;

    /** @var array ID категорий для поиска */
    public $categoryIds;

    /** @var string Интервал даты */
    public $period = 'week';
    public $remoteWork = false;
    public $empty;

    /** {@inheritDoc} */
    public function attributeLabels()
    {
        $parent = parent::attributeLabels();
        $parent['period'] = \Yii::t('app', 'Период');
        $parent['searchByName'] = \Yii::t('app', 'Поиск по названию');
        $parent['remoteWork'] = \Yii::t('app', 'Удаленная работа');
        $parent['empty'] = \Yii::t('app', 'Без откликов');
        return $parent;
    }

    /** {@inheritDoc} */
    public function rules()
    {
        $parent = parent::rules();
        $parent[] = [
            ['searchByName', 'period', 'categoryIds', 'remoteWork', 'empty'], 'safe'
        ];

        return $parent;
    }

    /**
     * Метод поиска
     *
     * @param array $params
     * @return ActiveDataProvider
     */
    public function search(array $params): ActiveDataProvider
    {
        $query = Task::find()->with(['city', 'category'])->new();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => \frontend\controllers\TaskController::PAGE_SIZE
            ]
        ]);

        if (!empty($params) && !$this->load($params)) {
            return $dataProvider;
        }

        if ($this->searchByName) {
            $query->andFilterWhere(['like', 'title', $this->searchByName]);
            return $dataProvider;
        }

        if (isset($this->remoteWork)) {
            $query->remoteWork($this->remoteWork);
        }

        if ($this->period) {
            $query->byPeriod($this->period);
        }

        if ($this->categoryIds) {
            $query->inCategories($this->categoryIds);
        }

        if ($this->empty) {
            $query->andFilterWhere(['not in', 'id', \frontend\models\TaskResponses::find()->select('DISTINCT(task_id)')]);
        }

        return $dataProvider;
    }

    /** 
     * Варианты интервалов
     */
    public function periodList()
    {
        return [
            '' => \Yii::t('app', 'За все время'),
            'day' => \Yii::t('app', 'За день'),
            'week' => \Yii::t('app', 'За неделю'),
            'month' => \Yii::t('app', 'За месяц')
        ];
    }
}
