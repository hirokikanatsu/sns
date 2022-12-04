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
    "twitter" => [
        "client_id" => env("TWITTER_AUTH_CLIENT_ID"),
        "client_secret" => env("TWITTER_AUTH_CLIENT_SECRET"),
        "redirect" => env("CALLBACK_URL"),
        // 'oauth'           => 2,
    ],
    'google' => [
        'client_id' => '136080944664-fgt34nsrcef9k66lvoc002fs787hmp1s.apps.googleusercontent.com',
        'client_secret' => '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',
        'redirect' => 'http://localhost:8080/login/google/callback',
    ],

];
