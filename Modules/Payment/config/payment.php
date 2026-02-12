<?php

return [
    'driver' => env('PAYMENT_GATEWAY', 'paddle'),

    'drivers' => [
        'paddle' => [
            'vendor_id' => env('PADDLE_VENDOR_ID'),
            'vendor_api_key' => env('PADDLE_VENDOR_API_KEY'),
            'webhook_secret' => env('PADDLE_WEBHOOK_SECRET'),
        ],
        'stripe' => [
            'key' => env('STRIPE_KEY'),
            'secret' => env('STRIPE_SECRET'),
            'webhook_secret' => env('STRIPE_WEBHOOK_SECRET'),
        ],
    ],

    'test' => [
        'plan' => env('PADDLE_TEST_PRICE_ID'),
        'subscription_name' => env('PAYMENT_TEST_SUBSCRIPTION_NAME', 'default'),
        'quantity' => env('PAYMENT_TEST_QUANTITY', 1),
        'return_url' => env('PAYMENT_TEST_RETURN_URL'),
    ],
];
