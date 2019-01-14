<?php
use backend\assets\TeamAsset;
use common\utils\helpers\Security;
use yii\bootstrap\BootstrapPluginAsset;
use yii\caching\FileCache;
use yii\i18n\PhpMessageSource;
use yii\web\JqueryAsset;
use yii\web\YiiAsset;

return [
    'name'       => 'Oh Vacation',
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'timeZone'   => 'Asia/Ho_Chi_Minh',
    'components' => [
        'cache'        => [
            'class' => FileCache::class,
        ],
        'i18n'         => [
            'translations' => [
                'yii' => [
                    'class'    => PhpMessageSource::class,
                    'basePath' => '@common/translations',
                    'fileMap'  => []
                ]
            ],
        ],
        'formatter'    => [
            'dateFormat'        => 'php:d-m-Y',
            'datetimeFormat'    => 'php:d-m-Y H:i:s',
            'timeFormat'        => 'H:i:s',
            'locale'            => 'vi',
            'defaultTimeZone'   => 'Asia/Ho_Chi_Minh',
            'decimalSeparator'  => '.',
            'thousandSeparator' => ',',
            'currencyCode'      => 'VND',
            'sizeFormatBase'    => 1000,
            'nullDisplay'       => ''
        ],
        'assetManager' => [
            'bundles'         => [
                JqueryAsset::class          => [
                    'js' => [
                        YII_ENV_DEV ? 'jquery.js' : 'jquery.min.js'
                    ]
                ],
                YiiAsset::class             => [
                    'jsOptions' => [
                        'position' => \yii\web\View::POS_HEAD,
                    ],
                ],
                BootstrapPluginAsset::class => [
                    'jsOptions' => ['position' => \yii\web\View::POS_HEAD],
                    'js'        => [
                        YII_ENV_DEV ? 'js/bootstrap.js' : 'js/bootstrap.min.js'
                    ],
                ],
                TeamAsset::class            => [
                    'jsOptions' => ['defer' => 'defer']
                ]
            ],
            'appendTimestamp' => true,
        ],
        'security'     => [
            'class'                => Security::class,
            'passwordHashStrategy' => 'password_hash',
            'authKeyInfo'          => 'CloudTeam',
            'kdfHash'              => 'sha384',
            'macHash'              => 'sha384',
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
    ],
    'language'   => 'vi'
];
