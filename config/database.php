<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Default Database Connection Name
    |--------------------------------------------------------------------------
    |
    | Here you may specify which of the database connections below you wish
    | to use as your default connection for all database work. Of course
    | you may use many connections at once using the Database library.
    |
    */

    'default' => env('DB_CONNECTION', 'mysql'),

    /*
    |--------------------------------------------------------------------------
    | Database Connections
    |--------------------------------------------------------------------------
    |
    | Here are each of the database connections setup for your application.
    | Of course, examples of configuring each database platform that is
    | supported by Laravel is shown below to make development simple.
    |
    |
    | All database work in Laravel is done through the PHP PDO facilities
    | so make sure you have the driver for your particular database of
    | choice installed on your machine before you begin development.
    |
    */

    'connections' => [

        'sqlite' => [
            'driver' => 'sqlite',
            'database' => env('DB_DATABASE', database_path('database.sqlite')),
            'prefix' => '',
        ],

        'mysql0' => [
            'driver' => 'mysql',
            'host' => env('DB_HOST', '127.0.0.1'),
            'port' => env('DB_PORT', '3306'),
            'database' => env('DB_DATABASE', ''),
            'username' => env('DB_USERNAME', ''),
            'password' => env('DB_PASSWORD', ''),
            'unix_socket' => env('DB_SOCKET', ''),
            'prefix' => env('DB_PREFIX', ''),
            'charset' => 'utf8',
            'collation' => 'utf8_general_ci',
            'strict' => false,
            'engine' => null,
//            'options'   =>[
//                PDO::ATTR_EMULATE_PREPARES => false,
//            ],
        ],

        'mysql' => [
            'driver' => 'mysql',
            'host' => env('DB_HOST', '127.0.0.1'),
            'port' => env('DB_PORT', '3306'),
            'database' => env('DB_DATABASE', ''),
            'username' => env('DB_USERNAME', ''),
            'password' => env('DB_PASSWORD', ''),
            'unix_socket' => env('DB_SOCKET', ''),
            'prefix' => env('DB_PREFIX', ''),
            'charset' => 'utf8',
            'collation' => 'utf8_general_ci',
            'strict' => false,
            'engine' => null,
//            'options'   =>[
//                PDO::ATTR_EMULATE_PREPARES => false,
//            ],
        ],

        'mysql_def' => [
            'driver' => 'mysql',
            'host' => env('DB_ORG_HOST', '127.0.0.1'),
            'port' => env('DB_ORG_PORT', '3306'),
            'database' => env('DB_DEF_DATABASE', ''),
            'username' => env('DB_DEF_USERNAME', ''),
            'password' => env('DB_DEF_PASSWORD', ''),
            'unix_socket' => env('DB_DEF_SOCKET', ''),
            'prefix' => env('DB_DEF_PREFIX', 'def_'),
            'charset' => 'utf8',
            'collation' => 'utf8_general_ci',
            'strict' => false,
            'engine' => null,
//            'options'   =>[
//                PDO::ATTR_EMULATE_PREPARES => false,
//            ],
        ],

        'mysql_test' => [
            'driver' => 'mysql',
            'host' => env('DB_ORG_HOST', '127.0.0.1'),
            'port' => env('DB_ORG_PORT', '3306'),
            'database' => env('DB_TEST_DATABASE', ''),
            'username' => env('DB_TEST_USERNAME', ''),
            'password' => env('DB_TEST_PASSWORD', ''),
            'unix_socket' => env('DB_TEST_SOCKET', ''),
            'prefix' => env('DB_TEST_PREFIX', 'test_'),
            'charset' => 'utf8',
            'collation' => 'utf8_general_ci',
            'strict' => false,
            'engine' => null,
//            'options'   =>[
//                PDO::ATTR_EMULATE_PREPARES => false,
//            ],
        ],

        'mysql_lw' => [
            'driver' => 'mysql',
            'host' => env('DB_ORG_HOST', '127.0.0.1'),
            'port' => env('DB_ORG_PORT', '3306'),
            'database' => env('DB_DEF_DATABASE', ''),
            'username' => env('DB_DEF_USERNAME', ''),
            'password' => env('DB_DEF_PASSWORD', ''),
            'unix_socket' => env('DB_DEF_SOCKET', ''),
            'prefix' => env('DB_DEF_PREFIX', 'lw_'),
            'charset' => 'utf8',
            'collation' => 'utf8_general_ci',
            'strict' => false,
            'engine' => null,
//            'options'   =>[
//                PDO::ATTR_EMULATE_PREPARES => false,
//            ],
        ],

        'mysql_atom' => [
            'driver' => 'mysql',
            'host' => env('DB_ATOM_HOST', '127.0.0.1'),
            'port' => env('DB_ATOM_PORT', '3306'),
            'database' => env('DB_ATOM_DATABASE', ''),
            'username' => env('DB_ATOM_USERNAME', ''),
            'password' => env('DB_ATOM_PASSWORD', ''),
            'unix_socket' => env('DB_ATOM_SOCKET', ''),
            'prefix' => env('DB_ATOM_PREFIX', 'atom_'),
            'charset' => 'utf8',
            'collation' => 'utf8_general_ci',
            'strict' => false,
            'engine' => null,
//            'options'   =>[
//                PDO::ATTR_EMULATE_PREPARES => false,
//            ],
        ],

        'mysql_org' => [
            'driver' => 'mysql',
            'host' => env('DB_ORG_HOST', '127.0.0.1'),
            'port' => env('DB_ORG_PORT', '3306'),
            'database' => env('DB_ORG_DATABASE', ''),
            'username' => env('DB_ORG_USERNAME', ''),
            'password' => env('DB_ORG_PASSWORD', ''),
            'unix_socket' => env('DB_ORG_SOCKET', ''),
            'prefix' => env('DB_ORG_PREFIX', 'org_'),
            'charset' => 'utf8',
            'collation' => 'utf8_general_ci',
            'strict' => false,
            'engine' => null,
//            'options'   =>[
//                PDO::ATTR_EMULATE_PREPARES => false,
//            ],
        ],

        'mysql_doc' => [
            'driver' => 'mysql',
            'host' => env('DB_DOC_HOST', '127.0.0.1'),
            'port' => env('DB_DOC_PORT', '3306'),
            'database' => env('DB_DOC_DATABASE', ''),
            'username' => env('DB_DOC_USERNAME', ''),
            'password' => env('DB_DOC_PASSWORD', ''),
            'unix_socket' => env('DB_DOC_SOCKET', ''),
            'prefix' => env('DB_DOC_PREFIX', 'doc_'),
            'charset' => 'utf8',
            'collation' => 'utf8_general_ci',
            'strict' => false,
            'engine' => null,
//            'options'   =>[
//                PDO::ATTR_EMULATE_PREPARES => false,
//            ],
        ],

        'mysql_k' => [
            'driver' => 'mysql',
            'host' => env('DB_K_HOST', '127.0.0.1'),
            'port' => env('DB_K_PORT', '3306'),
            'database' => env('DB_K_DATABASE', ''),
            'username' => env('DB_K_USERNAME', ''),
            'password' => env('DB_K_PASSWORD', ''),
            'unix_socket' => env('DB_K_SOCKET', ''),
            'prefix' => env('DB_K_PREFIX', 'k_'),
            'charset' => 'utf8',
            'collation' => 'utf8_general_ci',
            'strict' => false,
            'engine' => null,
//            'options'   =>[
//                PDO::ATTR_EMULATE_PREPARES => false,
//            ],
        ],

        'pgsql' => [
            'driver' => 'pgsql',
            'host' => env('DB_HOST', '127.0.0.1'),
            'port' => env('DB_PORT', '5432'),
            'database' => env('DB_DATABASE', 'forge'),
            'username' => env('DB_USERNAME', 'forge'),
            'password' => env('DB_PASSWORD', ''),
            'charset' => 'utf8',
            'prefix' => '',
            'schema' => 'public',
            'sslmode' => 'prefer',
        ],

        'sqlsrv' => [
            'driver' => 'sqlsrv',
            'host' => env('DB_HOST', 'localhost'),
            'port' => env('DB_PORT', '1433'),
            'database' => env('DB_DATABASE', 'forge'),
            'username' => env('DB_USERNAME', 'forge'),
            'password' => env('DB_PASSWORD', ''),
            'charset' => 'utf8',
            'prefix' => '',
        ],

    ],

    /*
    |--------------------------------------------------------------------------
    | Migration Repository Table
    |--------------------------------------------------------------------------
    |
    | This table keeps track of all the migrations that have already run for
    | your application. Using this information, we can determine which of
    | the migrations on disk haven't actually been run in the database.
    |
    */

    'migrations' => 'migrations',

    /*
    |--------------------------------------------------------------------------
    | Redis Databases
    |--------------------------------------------------------------------------
    |
    | Redis is an open source, fast, and advanced key-value store that also
    | provides a richer set of commands than a typical key-value systems
    | such as APC or Memcached. Laravel makes it easy to dig right in.
    |
    */

    'redis' => [

        'client' => 'predis',

        'default' => [
            'host' => env('REDIS_HOST', '127.0.0.1'),
            'password' => env('REDIS_PASSWORD', null),
            'port' => env('REDIS_PORT', 6379),
            'database' => 0,
        ],

    ],

];
