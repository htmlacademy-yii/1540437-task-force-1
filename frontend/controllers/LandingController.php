<?php
namespace frontend\controllers;

use SecureController;

class LandingController extends SecureController
{
    public function actionIndex()
    {
        return $this->render('index');
    }
}