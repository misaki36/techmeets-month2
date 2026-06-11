<?php

return [
    // APIルート全体に適用
    'paths' => ['api/*'],

    'allowed_methods' => ['*'],

    // フロントエンドのURLを許可する
    'allowed_origins' => [
        'http://localhost:5173',  // ReactのVite開発サーバー
    ],

    'allowed_origins_patterns' => [],
    'allowed_headers' => ['*'],
    'exposed_headers' => [],
    'max_age' => 0,
    'supports_credentials' => false,
];