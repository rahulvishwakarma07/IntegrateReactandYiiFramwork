<?php
use yii\filters\Cors;

$params = require __DIR__ . '/params.php';
$db = require __DIR__ . '/db.php';

$config = [
    'id' => 'basic',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm' => '@vendor/npm-asset',
    ],
    'components' => [
        'request' => [
            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
            'cookieValidationKey' => 'hello',
            'parsers' => [
                'application/json' => \yii\web\JsonParser::class,
            ]
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'user' => [
            'identityClass' => 'app\models\User',
            'enableAutoLogin' => true,
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'mailer' => [
            'class' => \yii\symfonymailer\Mailer::class,
            'viewPath' => '@app/mail',
            // send all mails to a file by default.
            'useFileTransport' => true,
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'db' => $db,
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
                'react/<path:.*>' => 'site/react',
                'DELETE logout' => 'user/logout',
                'GET doctor' => 'doctor/index',
                'GET count'  => 'doctor/count',
                'GET userappointment/<id:\d+>' => 'appointment/user-appointment',
                'POST doctordata/<id:\d+>' => 'doctor/doctor',
                'POST booking' => 'appointment/book-appointment',
                'POST update/<id:\d+>' => 'user/update',
                'GET userget/<id:\d+>' => 'user/get-user',
                'POST update-password/<id:\d+>' => 'user/update-password',
                // other rules
            ],
        ],
        'corsFilter' => [
            'class' => Cors::class,
            'cors' => [
                'Origin' => ['*'], // Allows requests from any origin
                'Access-Control-Request-Method' => ['*'], // Allows all methods
                'Access-Control-Request-Headers' => ['*'], // Allows all headers
                'Access-Control-Allow-Credentials' => true,
            ],
        ],
    ],
    'params' => $params,
];

if (YII_ENV_DEV) {
    // configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = [
        'class' => 'yii\debug\Module',
        // uncomment the following to add your IP if you are not connecting from localhost.
        //'allowedIPs' => ['127.0.0.1', '::1'],
    ];

    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
        // uncomment the following to add your IP if you are not connecting from localhost.
        //'allowedIPs' => ['127.0.0.1', '::1'],
    ];
}

return $config;
