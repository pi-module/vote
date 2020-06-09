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

namespace Module\Vote\Form;

use Pi;
use Laminas\InputFilter\InputFilter;

class ScoreFilter extends InputFilter
{
    public function __construct()
    {
        // id
        $this->add([
            'name'     => 'id',
            'required' => false,
        ]);
        // title
        $this->add([
            'name'     => 'title',
            'required' => true,
            'filters'  => [
                [
                    'name' => 'StringTrim',
                ],
            ],
        ]);
        // status
        $this->add([
            'name'     => 'status',
            'required' => true,
        ]);
        // module
        $this->add([
            'name'     => 'module',
            'required' => true,
        ]);
    }
}