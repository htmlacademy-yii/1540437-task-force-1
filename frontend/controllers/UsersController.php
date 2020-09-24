<?php

namespace frontend\controllers;

use app\bizzlogic\User;
use frontend\models\Users;

class UsersController extends FrontendController
{
    public function actionIndex()
    {
        $models = Users::find()
            ->asRole(User::ROLE_PERFORMER)
            ->orderBy('created_at ASC')
            ->all();
        
        return $this->render('index', [
            'models' => $models
        ]);
    }
}
