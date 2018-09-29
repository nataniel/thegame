<?php
return [
    'default_locale' => 'pl',
    'show_errors' => true,
    'session_name' => 'TheGameSession',

    'authentication' => [
        // implementation of E4u\Authentication\Identity interface
        'model' => Main\Model\User::class,
        'login' => 'security/login',
        'cookie_name' => 'TheGameAuthentication',
    ],

    'console' => [
        'game:server' => \Main\Model\Game\Server::class,
        'bootstrap4:compile' => \Main\Tools\Bootstrap4::class,
    ],
];