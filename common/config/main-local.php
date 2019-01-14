<?php
use yii\db\Connection;
use yii\swiftmailer\Mailer;

return [
    'components' => [
        'db'     => [
            'class'    => Connection::class,
            'dsn'      => 'mysql:host=localhost;dbname=oh_voucher',
//            'username' => 'ohvaca_cocobay',
//            'password' => 'ohvacation@2018',
            'username' => 'root',
            'password' => '',
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
                'host'       => 'mail.ohvacation.com',
                'username'   => 'booking@ohvacation.com',
                'password'   => 'Abc123#@!@',
                'port'       => 25,
                //'encryption' => 'ssl',

                //'host'       => '118.69.109.115',
                //'username'   => 'booking@ohvacation.com',
                //'password'   => 'Abc123#@!@',
                //'port'       => 587,
                'timeout'    => 200 //in second
            ],
        ],
    ],
];
