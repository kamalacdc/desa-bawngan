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

    'postmark' => [
        'key' => env('POSTMARK_API_KEY'),
    ],

    'resend' => [
        'key' => env('RESEND_API_KEY'),
    ],

    'ses' => [
        'key' => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
    ],

    'slack' => [
        'notifications' => [
            'bot_user_oauth_token' => env('SLACK_BOT_USER_OAUTH_TOKEN'),
            'channel' => env('SLACK_BOT_USER_DEFAULT_CHANNEL'),
        ],
    ],

    'spreadsheet' => [
        'population_id' => env('POPULATION_SPREADSHEET_ID', '1r_APDw4mDAqxteLmdb6gPNEdEaBm0MTtKEChybj9QOI'),
        'population_range' => env('POPULATION_SPREADSHEET_RANGE', ''),
        'budget_id' => env('BUDGET_SPREADSHEET_ID', '1Ze-RMNUgR6L9DLqUYTybf-_5RmgFf_zCxp-UJ0JLRmk'),
        'budget_range' => env('BUDGET_SPREADSHEET_RANGE', "'APBDes Bawangan 2026'!A1:C23"),
        'verify_ssl' => (bool) env('SPREADSHEET_VERIFY_SSL', true),
    ],

];
