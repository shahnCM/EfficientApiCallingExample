<?php

return [
    'empty_array_over_exception' => [
        'symbol_api' => env('EMPTY_ARRAY_OVER_EXCEPTION_FOR_SYMBOL_API', false),
        'history_api' => env('EMPTY_ARRAY_OVER_EXCEPTION_FOR_HISTORY_API', false),
    ],

    'rapid_api' => [
        'key' => env('RAPID_API_KEY'),
        'host' => env('RAPID_API_HOST', 'yh-finance.p.rapidapi.com'),
        'history_data_api_url' => env('RAPID_API_URL', 'https://yh-finance.p.rapidapi.com/stock/v3/get-historical-data'),
    ],

    'datahub' => [
        'symbol_list_api_url' => env('SYMBOL_LIST_API_URL', 'https://pkgstore.datahub.io/core/nasdaq-listings/nasdaq-listed_json/data/a5bc7580d6176d60ac0b2142ca8d7df6/nasdaq-listed_json.json')
    ]
];
