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
    'category' => [
        [
            'title' => _a('Admin'),
            'name'  => 'admin',
        ],
        [
            'title' => _a('Vote'),
            'name'  => 'vote',
        ],
    ],
    'item'     => [
        // Admin
        'admin_perpage'      => [
            'category'    => 'admin',
            'title'       => _a('Perpage'),
            'description' => '',
            'edit'        => 'text',
            'filter'      => 'number_int',
            'value'       => 50,
        ],
        'admin_count'        => [
            'category'    => 'admin',
            'title'       => _a('Vote count'),
            'description' => _a('Count of X last vote for show in admin'),
            'edit'        => 'text',
            'filter'      => 'number_int',
            'value'       => 500,
        ],
        // vote
        'vote_delay'         => [
            'category'    => 'vote',
            'title'       => _a('Delay time'),
            'description' => _a('Delay time between two vote for each user. According to second, Set 0 for cancel check'),
            'edit'        => 'text',
            'filter'      => 'number_int',
            'value'       => 60,
        ],
        'vote_anonymous'     => [
            'category'    => 'vote',
            'title'       => _a('Anonymous users can vote'),
            'description' => '',
            'edit'        => 'checkbox',
            'filter'      => 'number_int',
            'value'       => 0,
        ],
        'vote_credit'        => [
            'category'    => 'vote',
            'title'       => _a('Update user credit after vote'),
            'description' => '',
            'edit'        => 'checkbox',
            'filter'      => 'number_int',
            'value'       => 0,
        ],
        'vote_credit_amount' => [
            'category'    => 'vote',
            'title'       => _a('Vote credit amount'),
            'description' => '',
            'edit'        => 'text',
            'filter'      => 'number_int',
            'value'       => 0,
        ],
    ],
];