<?php

declare(strict_types=1);

return [
    'suppliers_files_path' => storage_path('data/suppliers'),
    'simulate_request_delay' => (int) env('SIMULATE_DELAY', 3), // seconds
    'suppliers_data_cache_ttl' => (int) env('SUPPLIERS_DATA_CACHE_TTL', 300), // seconds
    'suppliers_data_chunk' => (int) env('SUPPLIERS_DATA_CHUNK', 50), // items
    'simulate_request_conditions' => (bool) env('SIMULATE_REQUEST_CONDITIONS', false),
];
