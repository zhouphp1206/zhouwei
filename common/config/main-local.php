<?php
return [
    'components' => [
        'db' => [
            //配置主数据库服务器
            'class' => 'yii\db\Connection',
            'dsn' => 'mysql:host=120.78.123.82;dbname=demo',
            'username' => 'root',
            'password' => 'root',
            'charset' => 'utf8',

            // 配置从数据库服务器
            'slaveConfig' => [
                'username' => 'root',
                'password' => 'root',
                'attributes' => [
                    // use a smaller connection timeout
                    PDO::ATTR_TIMEOUT => 10,
                ],
                'charset' => 'utf8',
            ],
            // 配置从服务器组
            'slaves' => [
                ['dsn' => 'mysql:host=43.227.66.227;dbname=demo'],
            ],
        ],
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            'viewPath' => '@common/mail',
            // send all mails to a file by default. You have to set
            // 'useFileTransport' to false and configure a transport
            // for the mailer to send real emails.
            'useFileTransport' => true,
        ],
    ],
];
