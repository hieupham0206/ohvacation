<?php

namespace common\assets;

use yii\web\AssetBundle;

class DatepickerAsset extends AssetBundle
{
    public $sourcePath = '@bower/bootstrap-datepicker/dist';
    public $css = [
        'css/bootstrap-datepicker.min.css'
    ];
    public $js = [
        'js/bootstrap-datepicker.min.js',
        'locales/bootstrap-datepicker.vi.min.js'
    ];
    public $jsOptions = [
        'defer' => 'defer'
    ];
}