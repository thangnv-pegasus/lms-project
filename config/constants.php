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
        ]
    ]
];
