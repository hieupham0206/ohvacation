<?php

namespace common\assets;

use yii\web\AssetBundle;

class DatatablesAsset extends AssetBundle
{
    public $sourcePath = '@bower/datatables/media';
    public $css = [
        'css/dataTables.bootstrap.min.css',
//        'extensions/FixedColumns/css/fixedColumns.dataTables.min.css',
//        'extensions/FixedColumns/css/fixedColumns.bootstrap.min.css',
    ];
    public $js = [
        'js/jquery.dataTables.min.js',
        'js/dataTables.bootstrap.min.js',
        'js/dataTables.conditionalPaging.js',
//        'extensions/FixedColumns/js/dataTables.fixedColumns.min.js'
    ];
    public $jsOptions = [
        'defer' => 'defer'
    ];
}