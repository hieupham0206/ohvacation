<?php

namespace backend\assets;

use common\assets\DatatablesAsset;
use common\assets\DatepickerAsset;
use common\assets\NumeralAsset;
use common\assets\Select2Asset;
use common\assets\ToastrAsset;
use yii\web\AssetBundle;
use yii\bootstrap\BootstrapPluginAsset;
use yii\web\YiiAsset;

/**
 * Main backend application asset bundle.
 */
class AppAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';

    public $css = [
        'css/site.css',
    ];
    public $js = [
        'js/plugins/jquery.blockUI.min.js',
        'js/plugins/jquery.alphanum.min.js',
        'js/plugins/bootbox.min.js',
        'js/plugins/jquery.bt.min.js',
    ];
    public $depends = [
        YiiAsset::class,
        BootstrapPluginAsset::class,
        DatatablesAsset::class,
        Select2Asset::class,
        DatepickerAsset::class,
        ToastrAsset::class,
        NumeralAsset::class,
    ];
}
