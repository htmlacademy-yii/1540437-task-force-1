<?php
namespace frontend\controllers;

use frontend\models\forms\SignupForm;
use Yii;

class AuthController extends FrontendController
{
    /**
     * Действие для Авторизации пользователя
     */
    public function actionSignin()
    {

    }

    /**
     * Действие для регистрации пользователя
     */
    public function actionSignup()
    {
        $model = new SignupForm();

        if ($model->load(Yii::$app->request->post()) && $model->signup() ) {
            return $this->goHome();
        }

        return $this->render('signup', [
            'model' => $model
        ]);
    }
}
