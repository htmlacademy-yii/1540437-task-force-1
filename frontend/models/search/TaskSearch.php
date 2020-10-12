<?php

namespace frontend\models\search;

use DateTime;
use frontend\models\Task;
use yii\data\ActiveDataProvider;

class TaskSearch extends Task
{
    public $qname;

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
        $parent['qname'] = \Yii::t('app', 'Поиск по названию');
        $parent['remoteWork'] = \Yii::t('app', 'Удаленная работа');
        $parent['empty'] = \Yii::t('app', 'Без откликов');
        return $parent;
    }

    /** {@inheritDoc} */
    public function rules()
    {
        $parent = parent::rules();
        $parent[] = [
            ['qname', 'period', 'categoryIds', 'remoteWork', 'empty'], 'safe'
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
                'pageSize' => \frontend\controllers\TasksController::PAGE_SIZE
            ]
        ]);

        if (!empty($params) && !$this->load($params)) {
            return $dataProvider;
        }

        if ($this->qname) {
            $query->andFilterWhere(['like', 'title', $this->qname]);
            return $dataProvider;
        }

        if (isset($this->remoteWork)) {
            $query->withAddress($this->remoteWork);
        }

        if ($this->period) {
            $query->andFilterWhere(['>=', 'tasks.created_at', (new DateTime("-1 {$this->period}"))->format('Y-m-d')]);
        }

        if ($this->categoryIds) {
            $query->andFilterWhere(['tasks.category_id' => $this->categoryIds]);
        }

        if ($this->empty) {
            $taskResponsesQuery = \frontend\models\TaskResponses::find()->select('DISTINCT(task_id)');
            $query->andFilterWhere(['not in', 'id', $taskResponsesQuery]);
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
