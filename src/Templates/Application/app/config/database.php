<?php

/**
 * Returns a listing of configurations for your database.
 *
 * @var array
 */
return [
    'mysql' => [
    	/**
         * The driver to be used.
         *
         * @var string
         */
        'driver' => env('MYSQL_DRIVER', '{{ application.environment == 'development' ? database.driver : 'mysql' }}'),

        /**
         * Hostname to be used.
         *
         * @var string
         */
        'host' => env('MYSQL_HOSTNAME', '{{ application.environment == 'development' ? database.hostname : 'localhost' }}'),

        /**
         * Username to be used when connecting.
         *
         * @var string
         */
        'user' => env('MYSQL_USERNAME', '{{ application.environment == 'development' ? database.username : 'root' }}'),

        /**
         * Password to be used when connecting.
         *
         * @var string
         */
        'password' => env('MYSQL_PASSWORD', '{{ (application.environment == 'development' ? database.password ? database.password : '' : '') | raw }}'),

		/**
         * Name of the database.
         *
         * @var string
         */
        'dbname' => env('MYSQL_DATABASE', '{{ application.environment == 'development' ? database.name : 'development_db' }}'),

		/**
         * Character set to be used in the database.
         *
         * @var string
         */
        'charset' => env('MYSQL_CHARSET', '{{ application.environment == 'development' ? database.charset : 'utf8' }}'),
    ]
];
