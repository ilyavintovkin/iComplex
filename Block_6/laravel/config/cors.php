<?php

return [
    'paths' => ['api/*'],
    'allowed_origins' => ['http://localhost:3002'], // Адрес твоего Nuxt-приложения
    'allowed_methods' => ['*'],
    'allowed_headers' => ['*'],
    'exposed_headers' => [],
    'max_age' => 0,
    'supports_credentials' => false,
];
