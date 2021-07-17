<?php

namespace frontend\assets;

class AlertAssets extends \yii\web\AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'css/alert.css',
    ];

    public $js = [];

    public $depends = [
        AppAsset::class
    ];
}
