<?php

namespace frontend\widgets;

use frontend\models\forms\SigninForm;
use yii\base\Widget;

class WSignin extends Widget
{
    public $title = 'Вход на сайт';
    public $visible = true;
    public $isRemoteLogin = true;
    public $allowSubmit = false;

    // public $id;

    public function init()
    {
        parent::init();

        $this->registerJs();
    }

    public $model;

    public function run()
    {
        if ($this->visible) {
            return $this->render('wsignin/remote-login', [
                'id' => $this->getId(),
                'title' => $this->title,
                'model' => $this->getModel()
            ]);
        }
    }

    private function registerJs()
    {
        $formId = $this->getId();
        $js = <<< JS

            $('#$formId').on('beforeSubmit', function () {
                var yiiform = $(this);
                $.ajax({
                        type: yiiform.attr('method'),
                        url: yiiform.attr('action'),
                        data: yiiform.serializeArray(),
                    }
                ).done(function(data) {
                    if (data.success) {
                        window.location.href = data.redirect;
                    } else if (data.validation) {
                        yiiform.yiiActiveForm('updateMessages', data.validation ,true);
                    } else {

                    }
                });

                return false; // prevent default form submission
            });

        JS;
        $this->getView()->registerJs($js, \yii\web\View::POS_READY);
    }

    private function getModel()
    {
        return isset($this->model) ? $this->model : new SigninForm();
    }
}
