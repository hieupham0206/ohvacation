<?php

namespace common\assets;

use yii\web\AssetBundle;

class ToastrAsset extends AssetBundle
{
    public $sourcePath = '@bower/toastr';
    public $css = [
        'toastr.min.css'
    ];
    public $js = [
        'toastr.min.js'
    ];
    public $jsOptions = [
        'defer' => 'defer'
    ];
}