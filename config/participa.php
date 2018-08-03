<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Council details
    |--------------------------------------------------------------------------
    */

    /* The name of the city */
    'municipality' => 'Any City',

    /* The name of the council */
    'council_name' => 'Any Council',

    /* The council's home page */
    'council_url' => 'https://anycity.com',

    /* The council's logo / coat of arms */
    'council_logo' => 'council.png',

    /* The e-mail where users can contact for support */
    'contact_email' => 'participa@disedit.com',

    /* The council's address */
    'contact_address' => 'Pl. Major, 1',

    /* The council's contact phone */
    'contact_phone' => '44343242',

    /* The council's facebook page and app ID */
    'facebook' => 'https://facebook.com/council',
    'facebook_app_id' => '180444172483336',

    /* The council's twitter account */
    'twitter' => 'infoDisedit',

    /*
    |--------------------------------------------------------------------------
    | Application settings
    |--------------------------------------------------------------------------
    */

    /* Main logo to display on all pages */
    'logo' => null,

    /* Main logo for dark backgrounds */
    'logo_dark' => null,

    /* Navbar: light or colorful */
    'navbar' => 'colorful',

    /* Maximum votes a single IP may cast */
    'max_per_ip' => 20,

    /* Maxiumum times a single IP can fail an ID attempt */
    'max_failed_lookups' => 100,

    /* Maximum SMS a single voter ID may request */
    'sms_max_attempts' => 3,

    /* Whether voting should be anonymous or not */
    'anonymous_voting' => false,

    /* Whether IDs are hashed or not */
    'hashed_SIDs' => env('PARTICIPA_HASHED', false),

    /* Whether admins may look up IDs to troubleshoot in-person voting.
       If IDs are hashed this option cannot be true and will be ignored */
    'enable_ID_lookup' => true,

    /* Minumum age at which citizens may participate */
    'min_age' => 16,

    /* Whether to display total census number on public result pages */
    'display_census_number' => true,

    /* Should SMS verification be required for online voting? */
    'disable_SMS_verification' => false,

    /* Primary color of the application */
    'primary_color' => '#2980b9',

    /* Set up Google Analytics tracking */
    'google_analytics_ID' => 'UA-106217417-1',

    /*
    |--------------------------------------------------------------------------
    | Languages
    |--------------------------------------------------------------------------
    |
    | A list of available locales for the application. This array will be
    | used to display the language switcher's dropdown menu
    |
    */

    'languages' => [
        'ca' => 'Valencià',
        'es' => 'Castellano',
        'en' => 'English'
    ]
];
