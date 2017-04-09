<?php
/**
 * Pi Engine (http://pialog.org)
 *
 * @link            http://code.pialog.org for the Pi Engine source repository
 * @copyright       Copyright (c) Pi Engine http://pialog.org
 * @license         http://pialog.org/license.txt BSD 3-Clause License
 */

/**
 * @author Hossein Azizabadi <azizabadi@faragostaresh.com>
 */
namespace Module\Vote\Registry;

use Pi;
use Pi\Application\Registry\AbstractRegistry;

/**
 * Score list
 */
class ScoreList extends AbstractRegistry
{
    /** @var string Module name */
    protected $module = 'vote';

    /**
     * {@inheritDoc}
     */
    protected function loadDynamic($options = array())
    {
        $return = array();
        $where = array('status' => 1);
        $order = array('title ASC', 'id ASC');
        $select = Pi::model('score', $this->module)->select()->where($where)->order($order);
        $rowset = Pi::model('score', $this->module)->selectWith($select);
        foreach ($rowset as $row) {
            $return[$row->module][$row->id] = $row->toArray();
        }
        return $return;
    }

    /**
     * {@inheritDoc}
     * @param array
     */
    public function read()
    {
        $options = array();
        $result = $this->loadData($options);

        return $result;
    }

    /**
     * {@inheritDoc}
     * @param bool $name
     */
    public function create()
    {
        $this->clear('');
        $this->read();

        return true;
    }

    /**
     * {@inheritDoc}
     */
    public function setNamespace($meta = '')
    {
        return parent::setNamespace('');
    }

    /**
     * {@inheritDoc}
     */
    public function flush()
    {
        return $this->clear('');
    }
}
