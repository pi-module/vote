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
            'title' => __('Admin'),
            'name' => 'admin'
        ),
        array(
            'title' => __('Vote'),
            'name' => 'vote'
        ),
    ),
    'item' => array(
        // Admin
        'admin_perpage' => array(
            'category' => 'admin',
            'title' => __('Perpage'),
            'description' => '',
            'edit' => 'text',
            'filter' => 'number_int',
            'value' => 50
        ),
        'admin_count' => array(
            'category' => 'admin',
            'title' => __('Vote count'),
            'description' => __('Count of X last vote for show in admin'),
            'edit' => 'text',
            'filter' => 'number_int',
            'value' => 500
        ),
        // vote
        'vote_delay' => array(
            'category' => 'vote',
            'title' => __('Delay time'),
            'description' => __('Delay time between two vote for each user. According to second, Set 0 for cancel check'),
            'edit' => 'text',
            'filter' => 'number_int',
            'value' => 60
        ),
    ),
);