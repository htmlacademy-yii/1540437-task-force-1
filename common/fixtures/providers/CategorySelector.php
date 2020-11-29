<?php

namespace common\fixtures\providers;

use Faker\Provider\Base;

class CategorySelector extends Base
{
    /** @var \frontend\models\Category[] Collection */
    private $_categories;

    public function randomCategory()
    {
        return $this->generator->randomElement($this->getCategories())->id;
    }

    /**
     * ActiveRecord Collaction
     *
     * @return \frontend\models\Category[]
     */
    private function getCategories(): array
    {
        if (!$this->_categories) {
            $this->_categories = \frontend\models\Category::find()->all();
        }
        return $this->_categories;
    }
}
