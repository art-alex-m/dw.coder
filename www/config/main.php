<?php
$params = array_merge(
    require __DIR__ . '/../../common/config/params.php',
    require __DIR__ . '/../../common/config/params-local.php',
    require __DIR__ . '/params.php',
    require __DIR__ . '/params-local.php'
);

return [
    'id' => 'app-www',
    'name' => 'Public application',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'controllerNamespace' => 'www\controllers',
    'modules' => [
        'admin' => [
            'class' => '\www\modules\admin\AdminModule',
        ],
        'user' => [
            'class' => '\www\modules\user\UserModule',
        ],
        'api' => [
            'class' => '\www\modules\api\ApiModule',
        ],
    ],
    'components' => [
        'request' => [
            'csrfParam' => '_csrf-www',
        ],
        'user' => [
            'identityClass' => 'common\models\User',
            'enableAutoLogin' => true,
            'identityCookie' => ['name' => '_identity-www', 'httpOnly' => true],
        ],
        'session' => [
            // this is the name of the session cookie used for login on the www
            'name' => 'advanced-www',
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
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        /*
        'urlManager' => [
            'enablePrettyUrl' => true,
            'enableStrictParsing' => false,
            'showScriptName' => false,
            'rules' => [],
        ],
        */
    ],
    'params' => $params,
];
