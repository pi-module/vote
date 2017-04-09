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
use Module\Vote\Form\ScoreForm;
use Module\Vote\Form\ScoreFilter;

class ScoreController extends ActionController
{
    public function indexAction()
    {
        // Get info
        $list = array();
        $order = array('module DESC', 'id DESC');
        $select = $this->getModel('score')->select()->order($order);
        $rowset = $this->getModel('score')->selectWith($select);
        // Make list
        foreach ($rowset as $row) {
            $list[$row->id] = $row->toArray();
            switch ($row->module) {
                case 'news':
                    $list[$row->id]['module_view'] = __('News');
                    break;

                case 'event':
                    $list[$row->id]['module_view'] = __('Event');
                    break;

                case 'shop':
                    $list[$row->id]['module_view'] = __('Shop');
                    break;

                case 'video':
                    $list[$row->id]['module_view'] = __('Video');
                    break;

                case 'guide':
                    $list[$row->id]['module_view'] = __('Guide');
                    break;

                default:
                    $list[$row->id]['module_view'] = __('All modules');
                    break;
            }
        }
        // Set view
        $this->view()->setTemplate('score-index');
        $this->view()->assign('list', $list);
    }

    public function updateAction()
    {
        // Get id
        $id = $this->params('id');
        // Set form
        $form = new ScoreForm('score');
        if ($this->request->isPost()) {
            $data = $this->request->getPost();
            $form->setInputFilter(new ScoreFilter);
            $form->setData($data);
            if ($form->isValid()) {
                $values = $form->getData();
                // Save values
                if (!empty($values['id'])) {
                    $row = $this->getModel('score')->find($values['id']);
                } else {
                    $row = $this->getModel('score')->createRow();
                }
                $row->assign($values);
                $row->save();
                //
                Pi::registry('scoreList', 'vote')->clear();
                // Add jump
                $message = __('Score data saved successfully.');
                $this->jump(array('action' => 'index'), $message);
            }
        } else {
            if ($id) {
                $score = $this->getModel('score')->find($id)->toArray();
                $form->setData($score);
            }
        }
        // Set view
        $this->view()->setTemplate('score-update');
        $this->view()->assign('form', $form);
        $this->view()->assign('title', __('Manage score'));
    }
}