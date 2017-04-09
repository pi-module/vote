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
    'admin' => array(
        'score' => array(
            'label'       => _a('Score'),
            'permission'  => array(
                'resource'    => 'score',
            ),
            'route'       => 'admin',
            'controller'  => 'score',
            'action'      => 'index',

            'pages' => array(

                'score' => array(
                    'label'       => _a('Score'),
                    'permission'  => array(
                        'resource'    => 'score',
                    ),
                    'route'       => 'admin',
                    'controller'  => 'score',
                    'action'      => 'index',
                ),

                'update' => array(
                    'label'       => _a('Manage score'),
                    'permission'  => array(
                        'resource'    => 'score',
                    ),
                    'route'       => 'admin',
                    'controller'  => 'score',
                    'action'      => 'update',
                ),

            ),
        ),
        'point' => array(
            'label'       => _a('Last votes'),
            'permission'  => array(
                'resource'    => 'point',
            ),
            'route'       => 'admin',
            'controller'  => 'point',
            'action'      => 'index',
        ),
    ),
);