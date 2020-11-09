<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as Mailgun, Postmark, AWS and more. This file provides the de facto
    | location for this type of information, allowing packages to have
    | a conventional file to locate the various service credentials.
    |
    */

    'mailgun' => [
        'domain' => env('MAILGUN_DOMAIN'),
        'secret' => env('MAILGUN_SECRET'),
        'endpoint' => env('MAILGUN_ENDPOINT', 'api.mailgun.net'),
    ],

    'postmark' => [
        'token' => env('POSTMARK_TOKEN'),
    ],

    'ses' => [
        'key' => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
    ],

    // 設定facebook登入認證資料
    'facebook' => [
        'client_id'     => env('FB_CLIENT_ID'),
        'client_secret' => env('FB_CLIENT_SECRET'),
        'redirect'      => env('FB_REDIRECT'),
    ],

    // google 登入
    'google' => [
        'client_id' => '453343820007-7ve95p6p0ivglhn4atav31kop17vnp6j.apps.googleusercontent.com',         // Your Google Client ID
        'client_secret' => 'qpQKmqk828Q4qA8naaMUqfmS', // Your Google Client Secret
        'redirect' => 'https://ecom-laravel8.herokuapp.com/google-sign-in-callback',
    ],
];
