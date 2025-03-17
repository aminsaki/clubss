<?php

return [
    ///The settings are related to the dandelion messenger
    'wordpress' => [
        'get_id' => env('URL', 'https://holooacademy.com/wp-json/authUser/getId'),
        'init' => env('URL', 'https://holooacademy.com/wp-json/'),
    ],
    'maps' => [
        'init' => env('URL', 'https://map.holoo.co.ir/api/getAgent'),
    ],
    'ZarinPal' => [
        'merchant_id' => 'ed6b3481-231c-4236-bc91-1279e125a485',
//    'call_back' => 'https://clubs.holootech.ir/api/v1/payments/callback/verify',
        'call_back' => 'http://localhost:8000/api/v1/payments/callback/verify',
        'request' => 'https://api.zarinpal.com/pg/v4/payment/request.json',
        'verify' => 'https://api.zarinpal.com/pg/v4/payment/verify.json',
    ],

    'Kavenegar' => [
        'gateway' => env('KAVENEGAR_GATEWAY', '%s://api.kavenegar.com/v1/%s/%s/%s.json?receptor=%s&sender=%s&message=%s'),
        'api_key' => env('KAVENEGAR_APIKEY', '4954352F383964723255736C4D6C36507A3465496A4E6E594D61384D34474F36452B30685635474A577A6F3D'),
        'sender' => env('KAVENEGAR_SENDER', '200023067'), /// 10004004040 , 10003784
    ],
    'Pardakhtsazi' => [
        'init' => env('PARDAKHTSAZI_GATEWAY', 'https://openapi.pardakhtsazi.ir'),
    ],
    "novin" => [
        'terminal' => env('MELLAT_TERMINAL_ID', 'Your Terminal ID'),
        'username' => env('MELLAT_USERNAME', 'Your Username'),
        'password' => env('MELLAT_PASSWORD', 'Your Password'),
    ],
];
