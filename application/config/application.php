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

    /**
     * https://developers.facebook.com/apps/309373856092003/dashboard/
     */
    'facebook' => [
        'app_id' => '309373856092003',
        'app_secret' => 'b550f4271f384344212c5570f03abcfb',
        'default_graph_version' => 'v2.7',
    ],

    /**
     * https://console.developers.google.com/apis/dashboard?project=thegame-144417
     */
    'google' => [
        'client_id' => '1051081120403-cltcrljod8r6tipmibl76ms814bs1tlt.apps.googleusercontent.com',
        'client_secret' => '_Id4kC7jcfGXZc0f6YC-HYK0',
    ],

    /**
     * https://apps.twitter.com/app/12881912/keys
     */
    'twitter' => [
        'consumer_key' => 'CaaqV0tRjlpflLoFbCBkA4qlc',
        'consumer_secret' => 'H25PaEU7xNjvTpPCmSbnoGM4ttzqIuNMcl7MMSzDy86yYKK5oJ',
    ],

    /**
     * http://steamcommunity.com/dev/apikey
     */
    'steam' => [
        'api_key' => 'B950814D8E66B5319F7C4EFCE83F4454',
    ],

    /**
     * Mailer settings
     * @link http://framework.zend.com/manual/2.3/en/modules/zend.mail.smtp.options.html
     */
    'mailer' => [
        'type' => 'file',
        'options' => [
            'path' => 'logs',
            'callback'  => function ($transport) {
                return 'Message_' . microtime(true) . '_' . mt_rand() . '.txt';
            },
        ],
    ],

];