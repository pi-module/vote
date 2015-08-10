<?php
/**
 * Pi Engine (http://pialog.org)
 *
 * @link            http://code.pialog.org for the Pi Engine source repository
 * @copyright       Copyright (c) Pi Engine http://pialog.org
 * @license         http://pialog.org/license.txt New BSD License
 */

/**
 * @author Hossein Azizabadi <azizabadi@faragostaresh.com>
 */
return array(
    'category' => array(
        array(
            'title'        => _a('Admin'),
            'name' => 'admin'
        ),
        array(
            'title'        => _a('Vote'),
            'name' => 'vote'
        ),
    ),
    'item' => array(
        // Admin
        'admin_perpage' => array(
            'category'     => 'admin',
            'title'        => _a('Perpage'),
            'description'  => '',
            'edit'         => 'text',
            'filter'       => 'number_int',
            'value'        => 50
        ),
        'admin_count' => array(
            'category'     => 'admin',
            'title'        => _a('Vote count'),
            'description'  => _a('Count of X last vote for show in admin'),
            'edit'         => 'text',
            'filter'       => 'number_int',
            'value'        => 500
        ),
        // vote
        'vote_delay' => array(
            'category'     => 'vote',
            'title'        => _a('Delay time'),
            'description'  => _a('Delay time between two vote for each user. According to second, Set 0 for cancel check'),
            'edit'         => 'text',
            'filter'       => 'number_int',
            'value'        => 60
        ),
        'vote_anonymous' => array(
            'category' => 'vote',
            'title' => _a('Anonymous users can vote'),
            'description' => '',
            'edit' => 'checkbox',
            'filter' => 'number_int',
            'value' => 0
        ),
    ),
);