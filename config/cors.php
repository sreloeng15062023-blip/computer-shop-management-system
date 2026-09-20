<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Cross-Origin Resource Sharing (CORS) Configuration
    |--------------------------------------------------------------------------
    |
    | Enables communication between your Frontend (Vite / React)
    | and your Laravel REST API (port 8000).
    |
    */

    // Apply CORS rules to all /api/* routes and Sanctum CSRF endpoint
    'paths' => ['api/*', 'sanctum/csrf-cookie'],

    // Allow all standard HTTP methods: GET, POST, PUT, PATCH, DELETE, OPTIONS
    'allowed_methods' => ['*'],

    // Explicit origins for common local ports
    'allowed_origins' => [
        'http://localhost:5173',
        'http://127.0.0.1:5173',
        'http://localhost:5174',
        'http://127.0.0.1:5174',
        'http://localhost:5175',
        'http://127.0.0.1:5175',
        'http://localhost:3000',
        'http://127.0.0.1:3000',
    ],

    // Regex pattern matching ANY localhost or 127.0.0.1 port (e.g. 5173, 5174, etc.)
    'allowed_origins_patterns' => [
        '#^https?://(localhost|127\.0\.0\.1)(:\d+)?$#',
    ],

    // Allow all headers including Content-Type, Accept, and Authorization (Bearer token)
    'allowed_headers' => ['*'],

    'exposed_headers' => [],

    'max_age' => 0,

    'supports_credentials' => true,

];
