<?php

namespace frontend\assets;

use yii\web\AssetBundle;

/**
 * Main frontend application asset bundle.
 */
class AppAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'css/normalize.css',
        'css/style.css',
        'css/fix_layout.css?v=1.0.3'
    ];

    public $js = [
        'js/main.js'
    ];
    public $depends = [
    ];
}
