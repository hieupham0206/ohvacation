<?php
use yii\db\Connection;
use yii\swiftmailer\Mailer;

$params = array_merge(
    require(__DIR__ . '/../../common/config/params.php'),
    require(__DIR__ . '/../../common/config/params-local.php'),
    require(__DIR__ . '/params.php'),
    require(__DIR__ . '/params-local.php')
);

return [
    'id' => 'app-console',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'controllerNamespace' => 'console\controllers',
    'components' => [
        'log' => [
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'db'     => [
            'class'    => Connection::class,
            'dsn'      => 'mysql:host=localhost;dbname=cocobay_ohvacation',
            'username' => 'cocobay_ov',
            'password' => 'ohvacation@@CoCobay',
            'charset'  => 'utf8',
//            'enableSchemaCache' => true,
//            'enableQueryCache'  => true,
        ],
        'mailer' => [
            'class'            => Mailer::class,
            'viewPath'         => '@common/mail',
            'useFileTransport' => false,
            'transport'        => [
                'class'      => \Swift_SmtpTransport::class,
                //'host'       => 'smtp.gmail.com',
                //'username'   => 'hexyclone@gmail.com',
                //'password'   => 'hexy0206',
                //'port'       => 465,
                //'encryption' => 'ssl',
		'host'       => 'mail.ohvacation.com',
                'username'   => 'booking@ohvacation.com',
                'password'   => 'Abc123456',
                'port'		=> 25,
		'timeout'    => 200 //in second
            ],
        ],
    ],
    'params' => $params,
];
