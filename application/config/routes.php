<?php
/**
 * The routes are matched from LAST to FIRST !!
 */
return [
    /**
     * Home page route
     */
    'home' => [
        'type' => Zend\Mvc\Router\Http\Literal::class,
        'options' => [
            'route'    => '/',
            'defaults' => [
                'module'     => null,
                'controller' => 'index',
                'action'     => 'index',
            ],
        ],
    ],

    /**
     * Default route
     * @example /pages/show/1
     */
    'default' => [
        'type'    => Zend\Mvc\Router\Http\Segment::class,
        'options' => [
            'route'    => '/:controller[/:action[/:id]]',
            'constraints' => [
                'controller' => '\w[\w\-]*',
                'action'     => '\w[\w\-]*',
                'id'          => '\d+',
            ],
            'defaults' => [
                'module'     => null,
                'controller' => 'index',
                'action'     => 'index',
            ],
        ],
    ],

    /**
     * Reset cache
     */
    'reset' => [
        'type' => Zend\Mvc\Router\Http\Literal::class,
        'options' => [
            'route'    => '/reset',
            'defaults' => [
                'module'     => null,
                'controller' => 'admin',
                'action'     => 'reset',
            ],
        ],
    ],

    /**
     * A Game
     * @example /game/1
     */
    'game' => [
        'type'    => Zend\Mvc\Router\Http\Segment::class,
        'options' => [
            'route'    => '/game/:id',
            'constraints' => [
                'id'          => '\d+',
            ],
            'defaults' => [
                'module'     => null,
                'controller' => 'games',
                'action'     => 'index',
            ],
        ],
    ],
];