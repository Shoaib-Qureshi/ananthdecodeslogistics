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

    'razorpay' => [
        'key' => env('RAZORPAY_KEY_ID'),
        'secret' => env('RAZORPAY_KEY_SECRET'),
        'webhook_secret' => env('RAZORPAY_WEBHOOK_SECRET'),
        'company_name' => env('RAZORPAY_COMPANY_NAME', env('APP_NAME')),
    ],

    'bank_transfer' => [
        'account_name'   => env('BANK_ACCOUNT_NAME', 'ANANTH DECODES LOGISTICS PRIVATE LIMITED'),
        'account_number' => env('BANK_ACCOUNT_NUMBER', '51412842689'),
        'ifsc'           => env('BANK_IFSC', 'IDFB0080172'),
        'bank_name'      => env('BANK_NAME', 'IDFC FIRST Bank'),
        'branch'         => env('BANK_BRANCH', 'HSR Layout Branch, Ground Floor, Site No. 4 & 5, Bangalore - 560102'),
    ],

];
