<?php
/**
 * Pi Engine (http://piengine.org)
 *
 * @link            http://code.piengine.org for the Pi Engine source repository
 * @copyright       Copyright (c) Pi Engine http://piengine.org
 * @license         http://piengine.org/license.txt New BSD License
 */

/**
 * @author Hossein Azizabadi <azizabadi@faragostaresh.com>
 */
return [
    'admin' => [
        'score' => [
            'label'      => _a('Score'),
            'permission' => [
                'resource' => 'score',
            ],
            'route'      => 'admin',
            'controller' => 'score',
            'action'     => 'index',

            'pages' => [

                'score' => [
                    'label'      => _a('Score'),
                    'permission' => [
                        'resource' => 'score',
                    ],
                    'route'      => 'admin',
                    'controller' => 'score',
                    'action'     => 'index',
                ],

                'update' => [
                    'label'      => _a('Manage score'),
                    'permission' => [
                        'resource' => 'score',
                    ],
                    'route'      => 'admin',
                    'controller' => 'score',
                    'action'     => 'update',
                ],

            ],
        ],
        'point' => [
            'label'      => _a('Last votes'),
            'permission' => [
                'resource' => 'point',
            ],
            'route'      => 'admin',
            'controller' => 'point',
            'action'     => 'index',
        ],
    ],
];