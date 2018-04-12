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
        $order  = ['time_create DESC', 'id DESC'];
        $limit  = intval($this->config('admin_perpage'));
        $list   = [];
        // Get list of point
        $select = $this->getModel('point')->select()->order($order)->offset($offset)->limit($limit);
        $rowset = $this->getModel('point')->selectWith($select);
        // Make list
        foreach ($rowset as $row) {
            $list[$row->id]                = $row->toArray();
            $list[$row->id]['time_create'] = _date($list[$row->id]['time_create']);
            $list[$row->id]['user']        = Pi::user()->get($list[$row->id]['uid'], ['id', 'identity', 'name', 'email']);
        }
        // Set paginator
        $count     = ['count' => new Expression('count(*)')];
        $select    = $this->getModel('point')->select()->columns($count);
        $count     = $this->getModel('point')->selectWith($select)->current()->count;
        $paginator = Paginator::factory(intval($count));
        $paginator->setItemCountPerPage($this->config('admin_perpage'));
        $paginator->setCurrentPageNumber($page);
        $paginator->setUrlOptions([
            'router' => $this->getEvent()->getRouter(),
            'route'  => $this->getEvent()->getRouteMatch()->getMatchedRouteName(),
            'params' => array_filter([
                'module'     => $this->getModule(),
                'controller' => 'point',
                'action'     => 'index',
            ]),
        ]);
        // Set view
        $this->view()->setTemplate('point-index');
        $this->view()->assign('list', $list);
        $this->view()->assign('paginator', $paginator);
    }
}
