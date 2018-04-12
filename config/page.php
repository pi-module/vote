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
    // Admin section
    'admin' => [
        [
            'title'      => _a('Score'),
            'controller' => 'score',
            'permission' => 'score',
        ],
        [
            'title'      => _a('Last votes'),
            'controller' => 'point',
            'permission' => 'point',
        ],
    ],
];