<?php
namespace frontend\controllers;

use frontend\models\forms\SigninForm;
use frontend\models\forms\SignupForm;
use Yii;

class AuthController extends FrontendController
{

    /**
     * Действие для Авторизации пользователя
     */
    public function actionSignin()
    {
        $form = new SigninForm();

        if (Yii::$app->getRequest()->getIsPost()) {
            
            if ($form->load(Yii::$app->getRequest()->post()) && $form->validate()) {
                $user = $form->getUser();
                Yii::$app->user->login($user);
                return $this->goHome();
            }
            
        }
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
