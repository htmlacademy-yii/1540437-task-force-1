<?php
namespace frontend\widgets;

use frontend\models\forms\SigninForm;
use yii\base\Widget;

class WSignin extends Widget
{
    public $modelClass;

    public $title = 'Вход на сайт';
    public $visible = true;

    public function init()
    {
        parent::init();
        $this->modelClass = SignupForm::class;
    }

    public function run()
    {
        if ($this->visible) {
            $model = $this->getModel();
            return $this->render('wsignin/Landing', [
                'title' => $this->title,
                'model' => $model
            ]);
        }
    }

    private function getModel(): SigninForm
    {
        return new SigninForm();
    }

}