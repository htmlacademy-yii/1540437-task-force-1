<?php

namespace frontend\widgets;

use yii\helpers\Html;
/**
 * Иконка в завивисмости от пола.
 */
class GenderIcon extends \yii\base\Widget
{
    /** @var string Половая принадлежность */
    public $gender;

    /** @var array Html tag options */
    public $htmlOptions = [
        'width' => 65,
        'height' => 65
    ];

    /** {@inheritDoc} */
    public function run()
    {
        return $this->renderTag();
    }
    
    /** @return string Icons */
    private function getIconContent(): string
    {
        $iconName = '';
        switch ($this->gender) {
            case \app\bizzlogic\User::GENDER_MALE:
                $iconName = 'man';
                break;
            case \app\bizzlogic\User::GENDER_FEMALE:
                $iconName = 'woman';
                break;
            default:
                return null;
                break;
        }

        if (is_null($iconName)) {
            return null;
        }

        return "img/{$iconName}-glasses.jpg";
    }

    /** @return string Html tag with content */
    private function renderTag(): string
    {
        return Html::img($this->getIconContent(), $this->htmlOptions);
    }

}