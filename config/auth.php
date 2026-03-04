<?php

return [

    'defaults' => [
        'guard'     => 'web',
        'passwords' => 'students',
    ],

    'guards' => [
        'web' => [
            'driver'   => 'session',
            'provider' => 'students',
        ],
        'sanctum' => [
            'driver'   => 'sanctum',
            'provider' => 'students',
        ],
    ],

    'providers' => [
        'students' => [
            'driver' => 'eloquent',
            'model'  => App\Models\Student::class,
        ],
    ],

    'passwords' => [
        'students' => [
            'provider' => 'students',
            'table'    => 'password_reset_tokens',
            'expire'   => 60,
            'throttle' => 60,
        ],
    ],

    'password_timeout' => 10800,
];
