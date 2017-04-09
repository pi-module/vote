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

namespace Module\Vote\Controller\Admin;

use Pi;
use Pi\Mvc\Controller\ActionController;
use Pi\Paginator\Paginator;
use Zend\Db\Sql\Predicate\Expression;

class PointController extends ActionController
{
    public function indexAction()
    {
        // Get page
        $page = $this->params('page', 1);
        // Set info
        $offset = (int)($page - 1) * $this->config('admin_perpage');
        $order = array('time_create DESC', 'id DESC');
        $limit = intval($this->config('admin_perpage'));
        $list = array();
        // Get list of point
        $select = $this->getModel('point')->select()->order($order)->offset($offset)->limit($limit);
        $rowset = $this->getModel('point')->selectWith($select);
        // Make list
        foreach ($rowset as $row) {
            $list[$row->id] = $row->toArray();
            $list[$row->id]['time_create'] = _date($list[$row->id]['time_create']);
            $list[$row->id]['user'] = Pi::user()->get($list[$row->id]['uid'], array('id', 'identity', 'name', 'email'));
        }
        // Set paginator
        $count = array('count' => new Expression('count(*)'));
        $select = $this->getModel('point')->select()->columns($count);
        $count = $this->getModel('point')->selectWith($select)->current()->count;
        $paginator = Paginator::factory(intval($count));
        $paginator->setItemCountPerPage($this->config('admin_perpage'));
        $paginator->setCurrentPageNumber($page);
        $paginator->setUrlOptions(array(
            'router'    => $this->getEvent()->getRouter(),
            'route'     => $this->getEvent()->getRouteMatch()->getMatchedRouteName(),
            'params'    => array_filter(array(
                'module'        => $this->getModule(),
                'controller'    => 'point',
                'action'        => 'index',
            )),
        ));
        // Set view
        $this->view()->setTemplate('point-index');
        $this->view()->assign('list', $list);
        $this->view()->assign('paginator', $paginator);
    }
}
