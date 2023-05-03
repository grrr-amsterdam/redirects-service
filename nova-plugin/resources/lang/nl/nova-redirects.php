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
        "from" => "Van URL",
        "to" => "Naar URL",
        "permanently" => "Permanent",
        "permanent_help" =>
            'Door hier voor "Ja" te kiezen geef je aan services zoals Google door dat ze deze URL niet opnieuw hoeven te evalueren, en als permanent kunnen beschouwen.',
    ],
];
