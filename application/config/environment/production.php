<?php
return [
    'database' => [
        'driver' => 'pdo_mysql',
        'dbname' => 'xpect_thegame',
        'user' => 'xpect_xpect',
        'password' => 'uTabZxXU9',
        'host' => 'mysql.rebel.pl',
        'charset' => 'utf8',
    ],

    /**
     * Base URL for non-http requests and all other cases when
     * the Base URL cannot be determined automatically from $_SERVER
     */
    'base_url' => 'http://www.xpect.pl/thegame',
    # 'ssl_required' => true,

    /**
     * Doctrine configuration settings for Entity Manager
     * @link http://docs.doctrine-project.org/en/2.0.x/reference/configuration.html
     */
    'doctrine' => [
        'auto_generate_proxies' => false,
        'cache_class' => Doctrine\Common\Cache\ApcuCache::class,
        'cache_namespace' => 'thegame',
    ],

    # 'show_errors' => false,
];