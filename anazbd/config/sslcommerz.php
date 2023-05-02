<?php
if(env('APP_ENV','local') == "local"){
    return [
        'projectPath' => env('PROJECT_PATH'),
        'apiDomain' => env("SSL_API_DOMAIN", "https://sandbox.sslcommerz.com"),
        'apiCredentials' => [
            'store_id' => env('SSL_STORE_ID', 'greed5fb4d1ed05847'),
            'store_password' => env('SSL_STORE_PASSWORD', 'greed5fb4d1ed05847@ssl'),
        ],
        'apiUrl' => [
            'make_payment' => "/gwprocess/v3/api.php",
            'transaction_status' => "/validator/api/merchantTransIDvalidationAPI.php",
            'order_validate' => "/validator/api/validationserverAPI.php",
            'refund_payment' => "/validator/api/merchantTransIDvalidationAPI.php",
            'refund_status' => "/validator/api/merchantTransIDvalidationAPI.php",
        ],
        'connect_from_localhost' => env("IS_LOCALHOST", false),
        'success_url' => '/checkout/success',
        'failed_url' => '/checkout/fail',
        'cancel_url' => '/checkout/cancel',
        'ipn_url' => '/checkout/ipn',
    ];
}
return [
    'projectPath' => env('PROJECT_PATH'),
    'apiDomain' => env("SSL_API_DOMAIN", "https://securepay.sslcommerz.com"),
    'apiCredentials' => [
        'store_id' => env('SSL_STORE_ID', 'anazbdlive'),
        'store_password' => env('SSL_STORE_PASSWORD', '5F5334AC857FD64509'),
    ],
    'apiUrl' => [
        'make_payment' => "/gwprocess/v4/api.php",
        'transaction_status' => "/validator/api/merchantTransIDvalidationAPI.php",
        'order_validate' => "/validator/api/validationserverAPI.php",
        'refund_payment' => "/validator/api/merchantTransIDvalidationAPI.php",
        'refund_status' => "/validator/api/merchantTransIDvalidationAPI.php",
    ],
    'connect_from_localhost' => env("IS_LOCALHOST", false),
    'success_url' => '/checkout/success',
    'failed_url' => '/checkout/fail',
    'cancel_url' => '/checkout/cancel',
    'ipn_url' => '/checkout/ipn',
];
