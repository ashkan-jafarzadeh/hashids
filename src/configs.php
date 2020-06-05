<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Salt
    |--------------------------------------------------------------------------
    |
    | These are the salts of encryption. While the helper function use `main`
    | as default salt, you can always pass custom salts too. Just be sure
    | to define salts in your .env file and keep them unique over app.
    |
    */

    'salt'   => [
        "main" => env("HASHID_SALT_MAIN", null),
    ],

    /*
    |--------------------------------------------------------------------------
    | Bypass
    |--------------------------------------------------------------------------
    |
    | This is useful when you are in debug/development mode and you got sick
    | of constantly converting hashids and ids to each other and see what
    | is what. You can bypass mechanism by .env file to see real ids.
    |
    */

    "bypass" => (bool)env("HASHID_BYPASS", false),
];
