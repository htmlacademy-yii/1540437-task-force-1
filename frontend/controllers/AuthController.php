<?php

namespace frontend\controllers;

use frontend\models\forms\SigninForm;
use frontend\models\forms\SignupForm;
use frontend\widgets\WSignin;
use Yii;
use yii\helpers\Json;
use yii\widgets\ActiveForm;

class AuthController extends FrontendController
{

    /**
     * Действие для Авторизации пользователя
     */
    public function actionSignin()
    {
        if (Yii::$app->user->isGuest === false) {
            return $this->goHome();
        }

        $form = new SigninForm();
        $form->load(Yii::$app->request->post());

        if (Yii::$app->request->isAjax) {
            Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

            // Yii::$app->response->data = json_encode([

            // ]);

            $data = [
                'post' => Yii::$app->request->post(),
                'validate' => ActiveForm::validate($form)
            ];

            return $data;

            return \json_encode($data, 0);
            // return ActiveForm::validate($form);
        }

        if (Yii::$app->request->getIsPost()) {
            if (Yii::$app->request->isAjax) {

                $form->validate();

                // Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
                // return ActiveForm::validate($form);
                return $this->renderAjax('signin', [
                    'model' => $form
                ]);
            } elseif ($form->validate()) {
                Yii::$app->user->login($form->getUser());
                return $this->goHome();
            }
        }



        return $this->render('signin', [
            'model' => $form
        ]);
    }

    /**
     * Действие для регистрации пользователя
     */
    public function actionSignup()
    {
        $model = new SignupForm();

        if ($model->load(Yii::$app->request->post()) && $model->signup()) {
            return $this->goHome();
        }

        return $this->render('signup', [
            'model' => $model
        ]);
    }

    public function beforeAction($action)
    {
        if (Yii::$app->request->isAjax) {
            $this->enableCsrfValidation = false;
            // Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        }

        return parent::beforeAction($action);
    }
}
