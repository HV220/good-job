<?php

declare(strict_types=1);

use yii\debug\Module as DebugModule;
use yii\gii\Module;

$config = [
    'components' => [
        'request' => [
            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
            'cookieValidationKey' => '',
        ],
    ],
];

return $config;
