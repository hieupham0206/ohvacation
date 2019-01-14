<?php

use backend\components\Permission;
use common\models\User;
use yii\log\FileTarget;
use yii\web\GroupUrlRule;
use yii\web\Request;
use yii\web\UrlNormalizer;

$params  = array_merge(
    require __DIR__ . '/../../common/config/params.php',
    require __DIR__ . '/../../common/config/params-local.php',
    require __DIR__ . '/params.php',
    require __DIR__ . '/params-local.php'
);
//$baseUrl = str_replace('/backend/web', '', (new Request)->getBaseUrl());
$baseUrl = '/admin';
return [
    'id'                  => 'cloudteam-app-backend',
    'basePath'            => dirname(__DIR__),
    'controllerNamespace' => 'backend\controllers',
    'modules'             => [
        'system' => [
            'class' => \backend\modules\system\Module::class,
        ],
    ],
    'components'          => [
        'permission' => [
            'class' => Permission::class,
        ],
        'user'       => [
            'identityClass'   => User::class,
            'enableAutoLogin' => true,
            'identityCookie'  => [
                'name' => '_backendUser', // unique for backend
            ],
            'authTimeout'     => 60000
        ],
        'session'    => [
            'name'     => 'PHPBACKSESSID',
            'savePath' => sys_get_temp_dir(),
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
        'request'    => [
            'baseUrl'                => $baseUrl,
            'enableCsrfValidation'   => true,
            'enableCookieValidation' => false,
        ],
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName'  => false,
            'normalizer'      => [
                'class'                  => UrlNormalizer::class,
                'collapseSlashes'        => true,
                'normalizeTrailingSlash' => true,
                'action'                 => UrlNormalizer::ACTION_REDIRECT_TEMPORARY,// use temporary redirection instead of permanent for debugging
            ],
            'rules'           => [
                [
                    'class' => GroupUrlRule::class,
                    'rules' => [
                        '/'                      => 'site/index',
                        'login'                  => 'site/login',
                        'logout'                 => 'site/logout',
                        'reset-password'         => 'site/reset-password',
                        'request-password-reset' => 'site/request-password-reset',
                    ],
                ],
                '<controller>'                                    => '<controller>/index',
                '<module:\w+>/<controller:\w+>/<action:^[a-z-]+>' => '<module>/<controller>/index',
                '<controller:[a-z-]+>/<action:[a-z-]+>/<id:\d+>'  => '<controller>/<action>',
            ],
        ],
    ],
    'params'              => $params,
    'aliases'             => ['@upload' => $baseUrl . '/uploads'],
];
