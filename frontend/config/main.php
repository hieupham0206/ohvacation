<?php
use common\models\User;
use yii\log\FileTarget;
use yii\web\UrlNormalizer;

$params = array_merge(
    require __DIR__ . '/../../common/config/params.php',
    require __DIR__ . '/../../common/config/params-local.php',
    require __DIR__ . '/params.php',
    require __DIR__ . '/params-local.php'
);

return [
    'id'                  => 'app-frontend',
    'homeUrl'             => '/',
    'basePath'            => dirname(__DIR__),
    'bootstrap'           => ['log'],
    'controllerNamespace' => 'frontend\controllers',
    'components'          => [
        'request'    => [
            'csrfParam' => '_csrf-frontend',
            'baseUrl'   => '',
        ],
        'user'       => [
            'identityClass'   => User::class,
            'enableAutoLogin' => true,
            'identityCookie'  => ['name' => '_identity-frontend', 'httpOnly' => true],
        ],
        'session'    => [
            // this is the name of the session cookie used for login on the frontend
            'name' => 'advanced-frontend',
        ],
        'log'        => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets'    => [
                '404'         => [
                    'class'      => FileTarget::class,
                    'categories' => ['yii\web\HttpException:404'],
                    'levels'     => ['error'],
                    'logFile'    => '@runtime/logs/404.log',
                    'logVars'    => ['_POST', '$_GET']
                ],
                'http'        => [
                    'class'      => FileTarget::class,
                    'categories' => ['yii\web\HttpException:500', 'http'],
                    'levels'     => ['error'],
                    'logFile'    => '@runtime/logs/http.log',
                    'logVars'    => ['_POST', '$_GET']
                ],
                'db'          => [
                    'class'      => FileTarget::class,
                    'categories' => ['yii\db\*', 'db'],
                    'levels'     => ['error'],
                    'logFile'    => '@runtime/logs/db.log',
                    'logVars'    => ['_POST', '$_GET']
                ],
                'application' => [
                    'class'      => FileTarget::class,
                    'categories' => ['yii\db\*', 'yii\web\HttpException:*', 'application'],
                    'except'     => ['yii\web\HttpException:404'],
                    'levels'     => ['error', 'warning'],
                    'logFile'    => '@runtime/logs/app.log',
                    'logVars'    => ['_POST', '$_GET']
                ],
            ],
        ],
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName'  => false,
            'rules'           => [
                '<controller:[a-z-]+>/<action:[a-z-]+>/<id:\d+>' => '<controller>/<action>',
            ],
        ],
    ],
    'params'              => $params,
    'language'            => 'vi'
];
