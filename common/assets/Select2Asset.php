<?php

namespace common\assets;

use yii\web\AssetBundle;

class Select2Asset extends AssetBundle
{
    public $sourcePath = '@bower/select2/dist';
    public $css = [
        'css/select2.min.css',
    ];
    public $js = [
        'js/select2.min.js',
        'js/i18n/vi.js'
    ];
    public $jsOptions = [
        'defer' => 'defer'
    ];
}