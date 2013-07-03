<?php
/**
 * Vote module config
 *
 * You may not change or alter any portion of this comment or credits
 * of supporting developers from this source code or any supporting source code
 * which is considered copyrighted (c) material of the original comment or credit authors.
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
 *
 * @copyright       Copyright (c) Pi Engine http://www.xoopsengine.org
 * @license         http://www.xoopsengine.org/license New BSD License
 * @author          Hossein Azizabadi <azizabadi@faragostaresh.com>
 * @since           3.0
 * @package         Module\Vote
 * @version         $Id$
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