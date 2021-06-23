<?php

namespace frontend\controllers;

use frontend\models\Customer;

class CustomerController extends FrontendController
{
    public function actionProfile()
    {
        if (\Yii::$app->user->isGuest || \Yii::$app->user->role !== \app\bizzlogic\User::ROLE_CUSTOMER) {
            throw new \yii\web\ForbiddenHttpException('У вас нет прав для просмотра этой страницы');
        }

        $model = Customer::findOne(\Yii::$app->user->id);

        return $this->render('profile', ['model' => $model]);
    }
}
