<?php

declare(strict_types=1);

use yii\caching\FileCache;
use yii\symfonymailer\Mailer;

return [
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm' => '@vendor/npm-asset',
    ],
    'vendorPath' => dirname(__DIR__, 2) . '/vendor',
    'components' => [
        'cache' => [
            'class' => FileCache::class,
        ],
        'authManager' => [
            'class' => 'yii\rbac\DbManager',
        ],
        'i18n' => [
            'translations' => [
                'yii2mod.rbac' => [
                    'class' => 'yii\i18n\PhpMessageSource',
                    'basePath' => '@yii2mod/rbac/messages',
                ],
            ],
        ],
        'mailer' => [
            'class' => Mailer::class,
            'transport' => [
                'dsn' => 'smtp://' . $_ENV['SMTP_USER'] . ':' . $_ENV['SMTP_PASSWORD'] . '@' . $_ENV['SMTP_HOST'] . ':' . $_ENV['SMTP_PORT'],
            ],
        ],
    ],
];
