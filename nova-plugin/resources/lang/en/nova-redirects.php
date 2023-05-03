<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Nova Redirects
    |--------------------------------------------------------------------------
    |
    */

    "label" => "Redirects",
    "singularLabel" => "Redirect",
    "fields" => [
        "from" => "From URL",
        "to" => "To URL",
        "permanently" => "Permanent",
        "permanent_help" =>
            "Checking this box tells services like Google to not reevaluate this URL and consider this redirect to be permanent.",
    ],
];
