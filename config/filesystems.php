<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Default Filesystem Disk
    |--------------------------------------------------------------------------
    |
    | Here you may specify the default filesystem disk that should be used
    | by the framework. The "local" disk, as well as a variety of cloud
    | based disks are available to your application. Just store away!
    |
    */

    'default' => env('FILESYSTEM_DISK', 'local'),

    /*
    |--------------------------------------------------------------------------
    | Filesystem Disks
    |--------------------------------------------------------------------------
    |
    | Here you may configure as many filesystem "disks" as you wish, and you
    | may even configure multiple disks of the same driver. Defaults have
    | been set up for each driver as an example of the required values.
    |
    | Supported Drivers: "local", "ftp", "sftp", "s3"
    |
    */

    'disks' => [

        'local' => [
            'driver' => 'local',
            'root' => storage_path('app'),
            'throw' => false,
        ],

        // 'public' => [
        //     'driver' => 'local',
        //     'root' => storage_path('app/public'),
        //     'url' => env('APP_URL').'/storage',
        //     'visibility' => 'public',
        //     'throw' => false,
        // ],
        'public' => [
            'driver' => 'local',
            'root' => public_path('storage'),
            'url' => env('APP_URL').'/storage',
            'visibility' => 'public',
        ],

        // 's3' => [
        //     'driver' => 's3',
        //     'key' => env('AWS_ACCESS_KEY_ID'),
        //     'secret' => env('AWS_SECRET_ACCESS_KEY'),
        //     'region' => env('AWS_DEFAULT_REGION'),
        //     'bucket' => env('AWS_BUCKET'),
        //     'url' => env('AWS_URL'),
        //     'endpoint' => env('AWS_ENDPOINT'),
        //     'use_path_style_endpoint' => env('AWS_USE_PATH_STYLE_ENDPOINT', false),
        //     'throw' => false,
        // ],
        // 'remote' => [
        //     'driver' => 'sftp',
        //     'host' => env('SFTP_HOST'),        // Use the environment variable
        //     'port' => (int) env('SFTP_PORT'),        // Use the environment variable
        //     'username' => env('SFTP_USERNAME'), // Use the environment variable
        //     'password' => env('SFTP_PASSWORD'), // Use the environment variable
        //     'visibility' => 'public',
        //     'permPublic' => 0766,
        //     'root' => env('SFTP_ROOT'),        // Use the environment variable
        // ],
        'remote-sftp' => [
        'driver' => 'sftp',
        'host' => 'sftp://scontent.ansbd.net',
        'username' => 'root',
        'password' => 'N@ziR.69#',
        'visibility' => 'public',
        // 'permissions' => [
        //     'file' => [
        //         'public' => 436,
        //         'private' => 436,
        //      ],
        //      'dir' => [
        //          'public' => 509,
        //          'private' => 509,
        //      ],
        // ],
        'permPublic' => 0755,
        'port' => 7669,
        'root' => '/',
        'timeout' => 1800,
        // 'directoryPerm'=> 0755
    ],

    ],

    /*
    |--------------------------------------------------------------------------
    | Symbolic Links
    |--------------------------------------------------------------------------
    |
    | Here you may configure the symbolic links that will be created when the
    | `storage:link` Artisan command is executed. The array keys should be
    | the locations of the links and the values should be their targets.
    |
    */

    'links' => [
        public_path('storage') => storage_path('app/public'),
    ],

];
