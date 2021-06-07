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

            document.getElementById("$formId").addEventListener('submit', function(event){
                event.preventDefault();
                var httpRequest = new XMLHttpRequest();

                httpRequest.open('POST', event.target.action);
                httpRequest.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
                // httpRequest.setRequestHeader("Content-Type", "multipart/form-data");
                httpRequest.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
                httpRequest.send(new FormData(document.getElementById(event.target.id)));

                if (httpRequest.readyState === XMLHttpRequest.DONE) {
                    if (httpRequest.status === 200) {
                        alert(httpRequest.responseText);
                    } else {
                        alert('There was a problem with the request.');
                    }
                }

                
            });

        JS;
        $this->getView()->registerJs($js, \yii\web\View::POS_LOAD);
    }

    private function getModel()
    {
        return isset($this->model) ? $this->model : new SigninForm();
    }
}
