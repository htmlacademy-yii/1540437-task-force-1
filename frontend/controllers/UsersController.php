<?php

namespace frontend\controllers;

use common\models\Users;

class UsersController extends FrontendController
{
    public function actionIndex()
    {
        $models = Users::find()->all();
        
        return $this->render('index', [
            'models' => $models
        ]);
    }
}
