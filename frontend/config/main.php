<?php

$params = array_merge(
    require __DIR__ . '/../../common/config/params.php',
    require __DIR__ . '/../../common/config/params-local.php',
    require __DIR__ . '/params.php',
    require __DIR__ . '/params-local.php'
);

return [
    'id' => 'app-frontend',
    'language' => 'ru',
    'name' => 'TaskForce',
    'basePath' => dirname(__DIR__),
    // 'bootstrap' => ['log', 'common\widgets\Dropzone'],
    'bootstrap' => ['log'],
    'controllerNamespace' => 'frontend\controllers',
    'defaultRoute' => 'landing',
    'components' => [
        'request' => [
            'csrfParam' => '_csrf-frontend',
        ],
        'user' => [
            'class' => \common\components\WebUser::class,
        ],
        'session' => [
            // this is the name of the session cookie used for login on the frontend
            'name' => 'advanced-frontend',
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
                // '/' => '/',
                '/signup' => 'auth/signup',
                '/signin' => 'auth/signin',
                '/<controller>s' => '<controller>/index',
                '/<controller>/view/<id:\d+>' => '<controller>/view',
                '/<controller>/<id:\d+>/<action>' => '<controller>/<action>',
            ],
        ],
    ],
    'params' => $params,
];
