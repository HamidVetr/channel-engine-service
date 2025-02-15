<?php

declare(strict_types=1);

return [
    'api' => [
        'version'  => env('CHANNEL_ENGINE_API_VERSION', 'v2'),
        'base_url' => env('CHANNEL_ENGINE_API_BASE_URL', 'https://api-dev.channelengine.net/api'),
        'key'      => env('CHANNEL_ENGINE_API_KEY'),
    ],
];
