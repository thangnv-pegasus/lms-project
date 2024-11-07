<?php

return [
    'api_errors' => [
        401 => [
            'http_status' => \Symfony\Component\HttpFoundation\Response::HTTP_UNAUTHORIZED,
            'msg' => 'Unauthorized',
        ],
        403 => [
            'http_status' => \Symfony\Component\HttpFoundation\Response::HTTP_FORBIDDEN,
            'msg' => 'Forbidden',
        ],
        404 => [
            'http_status' => \Symfony\Component\HttpFoundation\Response::HTTP_NOT_FOUND,
            'msg' => 'Not found',
        ],
        422 => [
            'http_status' => \Symfony\Component\HttpFoundation\Response::HTTP_UNPROCESSABLE_ENTITY,
            'msg' => 'Please check your data',
        ],
        500 => [
            'http_status' => \Symfony\Component\HttpFoundation\Response::HTTP_INTERNAL_SERVER_ERROR,
            'msg' => 'Server error',
        ],
    ],
    'pagination' => [
        'default_limit' => 12,
        'first_page' => 1,
    ],
    'users' => [
        'gender' => [
            'male' => 1,
            'female' => 2,
            'other' => 3,
        ],
        'role' => [
            'admin' => 1,
            'department' => 2,
            'teacher' => 3,
            'student' => 4
        ]
    ]
];
