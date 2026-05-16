<?php

return [
  'paths' => ['api/*', 'sanctum/csrf-cookie'],

  'allowed_methods' => ['*'],

  'allowed_origins' => [
    'https://ujian.beasiswamncu.com',
    'http://localhost:5173',
    'http://localhost:5174',
  ],

  'allowed_origins_patterns' => [],

  'allowed_headers' => ['*'],

  'exposed_headers' => [],

  'max_age' => 0,

  // UBAH KE TRUE - penting untuk login!
  'supports_credentials' => true,
];