<?php

declare(strict_types=1);

return [
    'user.passwordResetTokenExpire' => 3600,
    'user.passwordMinLength' => 8,
    'adminEmail' => 'admin@example.com',
    'hail812/yii2-adminlte3' => [
        'pluginMap' => [
            'sweetalert2' => [
                'css' => 'sweetalert2-theme-bootstrap-4/bootstrap-4.min.css',
                'js' => 'sweetalert2/sweetalert2.min.js'
            ],
            'toastr' => [
                'css' => ['toastr/toastr.min.css'],
                'js' => ['toastr/toastr.min.js']
            ],
        ]
    ],
    'bsVersion' => '5.x',
];
