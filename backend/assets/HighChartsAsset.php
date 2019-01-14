<?php

namespace backend\assets;

use yii\web\AssetBundle;

/**
 * Team asset bundle.
 */
class HighChartsAsset extends AssetBundle
{
    public $sourcePath = '@bower/highcharts';

    public $js = [
        'highcharts.js',
    ];

    public $css = [
        'css/highcharts.css'
    ];
}
