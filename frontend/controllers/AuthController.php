<?php

namespace frontend\controllers;

use frontend\models\forms\SigninForm;
use frontend\models\forms\SignupForm;

use Yii;

use yii\helpers\Url;
use yii\widgets\ActiveForm;

class AuthController extends \yii\web\Controller
{

    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => \yii\filters\AccessControl::class,
                'only' => ['logout', 'signup', 'signin'],
                'rules' => [
                    [
                        'actions' => ['signup', 'signin'],
                        'allow' => true,
                        'roles' => ['?'],
                    ],
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => \yii\filters\VerbFilter::class,
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

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
            $data['success'] = false;
            $data['validation'] = ActiveForm::validate($form);

            if (empty($data['validation'])) {
                $data['success'] = true;
            }

            if ($data['success'] && $form->login()) {
                $data['redirect'] = Url::toRoute($this->goHome(), true);
            }

            return $data;
        }

        if ($form->validate() && $form->login()) {
            return $this->goHome();
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

    /**
     * Действия для выхода из системы
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();
        return $this->goHome();
    }

    public function beforeAction($action)
    {
        return parent::beforeAction($action);
    }
}
