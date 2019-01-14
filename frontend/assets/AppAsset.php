<?php

namespace frontend\assets;

use common\assets\DatatablesAsset;
use common\assets\DatepickerFrontAsset;
use common\assets\NumeralAsset;
use yii\bootstrap\BootstrapPluginAsset;
use yii\web\AssetBundle;
use yii\web\YiiAsset;

// use common\assets\JqueryAsset;

/**
 * Main frontend application asset bundle.
 */
class AppAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'templates/css/font-awesome.css',
        // 'templates/css/style.css',
    ];
    public $js = [
        // 'templates/js/jquery-2.1.4.min.js',
        'templates/js/jquery.blockUI.min.js',
        'templates/js/moment.js',
        'templates/js/jquery.alphanum.min.js',
        'templates/js/bootbox.min.js',
//        'templates/js/team.js',
    ];
    public $depends = [
        YiiAsset::class,
        BootstrapPluginAsset::class,
        DatatablesAsset::class,
        DatepickerFrontAsset::class,
        NumeralAsset::class,
    ];
}
