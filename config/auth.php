<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Authentication Defaults
    |--------------------------------------------------------------------------
    |
    | This option controls the default authentication "guard" and password
    | reset options for your application. You may change these defaults
    | as required, but they're a perfect start for most applications.
    |
    */

    'defaults' => [
        'guard' => 'web',
        'passwords' => 'users',
    ],

    /*
    |--------------------------------------------------------------------------
    | Authentication Guards
    |--------------------------------------------------------------------------
    |
    | Next, you may define every authentication guard for your application.
    | Of course, a great default configuration has been defined for you
    | here which uses session storage and the Eloquent user provider.
    |
    | All authentication drivers have a user provider. This defines how the
    | users are actually retrieved out of your database or other storage
    | mechanisms used by this application to persist your user's data.
    |
    | Supported: "session", "token"
    |
    */

    'guards' => [

        'web' => [
            'driver' => 'session',
            'provider' => 'web',
        ],

        'test' => [
            'driver' => 'session',
            'provider' => 'test',
        ],




        'gps' => [
            'driver' => 'session',
            'provider' => 'gps',
        ],
        'gps_admin' => [
            'driver' => 'session',
            'provider' => 'gps_admins',
        ],
        'test_gps' => [
            'driver' => 'session',
            'provider' => 'test',
        ],
        'test_gps_admin' => [
            'driver' => 'session',
            'provider' => 'test',
        ],




        'user' => [
            'driver' => 'session',
            'provider' => 'users',
        ],
        'test_user' => [
            'driver' => 'session',
            'provider' => 'test',
        ],




        'admin' => [
            'driver' => 'session',
            'provider' => 'admins',
        ],
        'test_admin' => [
            'driver' => 'session',
            'provider' => 'test',
        ],




        'super' => [
            'driver' => 'session',
            'provider' => 'super',
        ],
        'super_admin' => [
            'driver' => 'session',
            'provider' => 'super_admins',
        ],
        'test_super' => [
            'driver' => 'session',
            'provider' => 'test_super',
        ],
        'test_super_admin' => [
            'driver' => 'session',
            'provider' => 'test',
        ],




        'org' => [
            'driver' => 'session',
            'provider' => 'org',
        ],
        'org_admin' => [
            'driver' => 'session',
            'provider' => 'org_admins',
        ],
        'test_org' => [
            'driver' => 'session',
            'provider' => 'test',
        ],
        'test_org_admin' => [
            'driver' => 'session',
            'provider' => 'test',
        ],




        'doc' => [
            'driver' => 'session',
            'provider' => 'doc',
        ],
        'doc_admin' => [
            'driver' => 'session',
            'provider' => 'doc_admins',
        ],
        'test_doc' => [
            'driver' => 'session',
            'provider' => 'test',
        ],
        'test_doc_admin' => [
            'driver' => 'session',
            'provider' => 'test',
        ],




        'atom' => [
            'driver' => 'session',
            'provider' => 'atom',
        ],
        'atom_admin' => [
            'driver' => 'session',
            'provider' => 'atom_admins',
        ],
        'test_atom' => [
            'driver' => 'session',
            'provider' => 'test',
        ],
        'test_atom_admin' => [
            'driver' => 'session',
            'provider' => 'test',
        ],




        'api' => [
            'driver' => 'token',
            'provider' => 'users',
        ],
        'test_api' => [
            'driver' => 'token',
            'provider' => 'test',
        ],

    ],

    /*
    |--------------------------------------------------------------------------
    | User Providers
    |--------------------------------------------------------------------------
    |
    | All authentication drivers have a user provider. This defines how the
    | users are actually retrieved out of your database or other storage
    | mechanisms used by this application to persist your user's data.
    |
    | If you have multiple user tables or models you may configure multiple
    | sources which represent each model / table. These sources may then
    | be assigned to any extra authentication guards you have defined.
    |
    | Supported: "database", "eloquent"
    |
    */

    'providers' => [

        'web' => [
            'driver' => 'eloquent',
            'model' => App\User::class,
        ],


        'gps' => [
            'driver' => 'eloquent',
            'model' => App\User::class,
        ],
        'gps_admins' => [
            'driver' => 'eloquent',
            'model' => App\User::class,
        ],


        'users' => [
            'driver' => 'eloquent',
            'model' => App\User::class,
        ],


        'admins' => [
            'driver' => 'eloquent',
            'model' => App\User::class,
        ],


        'super' => [
            'driver' => 'eloquent',
            'model' => App\User::class,
        ],
        'super_admins' => [
            'driver' => 'eloquent',
            'model' => App\User::class,
        ],
        'test_super' => [
            'driver' => 'eloquent',
            'model' => App\User::class,
        ],
        'test_super_admins' => [
            'driver' => 'eloquent',
            'model' => App\User::class,
        ],


        'org' => [
            'driver' => 'eloquent',
            'model' => App\User::class,
        ],
        'org_admins' => [
            'driver' => 'eloquent',
            'model' => App\User::class,
        ],


        'doc' => [
            'driver' => 'eloquent',
            'model' => App\User::class,
        ],
        'doc_admins' => [
            'driver' => 'eloquent',
            'model' => App\User::class,
        ],


        'atom' => [
            'driver' => 'eloquent',
            'model' => App\User::class,
        ],
        'atom_admins' => [
            'driver' => 'eloquent',
            'model' => App\User::class,
        ],




        'test' => [
            'driver' => 'eloquent',
            'model' => App\User::class,
        ],

        // 'users' => [
        //     'driver' => 'database',
        //     'table' => 'users',
        // ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Resetting Passwords
    |--------------------------------------------------------------------------
    |
    | You may specify multiple password reset configurations if you have more
    | than one user table or model in the application and you want to have
    | separate password reset settings based on the specific user types.
    |
    | The expire time is the number of minutes that the reset token should be
    | considered valid. This security feature keeps tokens short-lived so
    | they have less time to be guessed. You may change this as needed.
    |
    */

    'passwords' => [
        'users' => [
            'provider' => 'users',
            'table' => 'password_resets',
            'expire' => 60,
        ],
    ],

];
