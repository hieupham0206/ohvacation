<?php

namespace backend\assets;

use yii\web\AssetBundle;

/**
 * Team asset bundle.
 */
class TeamAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';

    public $css = [
        'css/team.css',
    ];
    //java -jar closure.jar --js team.js --js_output_file team.min.js
    public $js = [
        'js/team/lodash.min.js',
        'js/team/team.js',
    ];
}
