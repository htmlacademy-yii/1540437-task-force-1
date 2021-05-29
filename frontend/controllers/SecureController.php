<?php

use yii\filters\AccessControl;
use yii\web\Controller;

abstract class SecureController extends Controller
{
    public function behaviors()
    {
        $behaviors = parent::behaviors();

        $behaviors['access'] = [
            'class' => AccessControl::class,
            'except' => [ 'signin', 'signup' ],
            'rules' => [
                'actions' => ['*'],
                'allow' => false,
                'roles' => [ '?' ]
            ]
        ];

        return $behaviors;
    }
}