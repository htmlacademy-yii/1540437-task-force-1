<?php

namespace common\widgets;

use yii\helpers\Html;
use yii\base\Widget;

class Stars extends Widget
{
    /** @var string Тэг, по умолчанию `span` */
    public $tag = 'span';

    /** @var int Максимальнео число звезд. По умолчанию `true` */
    public $max = 5;

    /** @var bool По умолчанию `true` */
    public $showRating = true;

    /** @var string Класс, пустой звезды */
    public $emptyStarClass = 'star-disabled';
    
    /** @var float Рейтинг */
    public $rating;

    /** {@inheritDoc} */
    public function run(): string
    {
        $html = '';
        for($i=0; $i < $this->max; $i++) {
            $isEmptyStar = floor($this->rating) <= $i;
            $html .= $this->renderStar($isEmptyStar);
        }

        if ($this->showRating) {
            $html .= $this->rating;
        }

        return $html;
    }

    /**
     * Рендер звезды, полной или пустой
     *
     * @param bool $isEmptyStar Default false
     * @return string
     */
    private function renderStar(bool $isEmptyStar = false): string
    {
        $htmlOptions = [];
        if ($isEmptyStar) {
            Html::addCssClass($htmlOptions, ['class' => $this->emptyStarClass]);
        }
        return Html::tag($this->tag, '', $htmlOptions);
    }
}
