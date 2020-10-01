<?php

namespace common\widgets;

use yii\base\Widget;

class PluralTemplates extends Widget
{
    public $template;
    public $count;

    public function init()
    {
    }

    public function run()
    {
        return 'Template: ';
    }
}
