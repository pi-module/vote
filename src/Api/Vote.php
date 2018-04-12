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

namespace Module\Vote\Api;

use Pi;
use Pi\Application\Api\AbstractApi;

/*
 * Pi::api('vote', 'vote')->doVote($params);
 * Pi::api('vote', 'vote')->getVoteScore($module, $table, $item);
 */

class Vote extends AbstractApi
{
    public function doVote($params)
    {
        // Chech vote number
        if (!in_array($params['vote'], array('-1', '1', '2', '3', '4', '5', '6', '7', '8', '9', '10'))) {
            $return['title'] = __('Error to voting');
            $return['message'] = __('Your vote number is not true');
            $return['status'] = 0;
        } else {
            $return = $this->vote(
                $params['to'],
                $params['table'],
                $params['item'],
                $params['vote'],
                isset($params['score']) ? $params['score'] : 1,
                isset($params['submodule']) ? $params['submodule'] : ''
            );
        }
        return $return;
    }

    protected function vote($module, $table, $item, $vote, $score = 1, $subModule = '')
    {
        // Get config
        $config = Pi::service('registry')->config->read('vote', 'vote');

        // Get user
        $uid = Pi::user()->getId();
        $ip = Pi::user()->getIp();

        // Check user
        if ($uid == 0 && !$config['vote_anonymous']) {
            $return['title'] = __('Error to voting');
            $return['message'] = __('Please login for vote');
            $return['status'] = 0;
        } else {
            // user voted to this item ?
            if ($uid > 0) {
                $where = array('uid' => $uid, 'item' => $item, 'table' => $table, 'module' => $module, 'score' => $score);
                $select = Pi::model('point', $this->getModule())->select()->where($where);
                $count = Pi::model('point', $this->getModule())->selectWith($select)->count();
            } else {
                $where = array('ip' => $ip, 'item' => $item, 'table' => $table, 'module' => $module, 'score' => $score);
                $select = Pi::model('point', $this->getModule())->select()->where($where);
                $count = Pi::model('point', $this->getModule())->selectWith($select)->count();
            }
            // Check delay
            $delay = true;
            if ($config['vote_delay']) {
                $delay = $this->checkDelay($uid, $ip, $config['vote_delay']);
            }
            // Save
            if (!$count && $delay) {
                // Get item
                $item_row = Pi::model($table, $module)->find($item);
                $item_row->point = $item_row->point + $vote;
                $item_row->count = $item_row->count + 1;
                $item_row->save();
                // create point row
                $point_row = Pi::model('point', $this->getModule())->createRow();
                $point_row->uid = $uid;
                $point_row->item = $item;
                $point_row->table = $table;
                $point_row->module = $module;
                $point_row->point = $vote;
                $point_row->score = $score;
                $point_row->ip = $ip;
                $point_row->time_create = time();
                $point_row->save();
                // Return
                $return['point'] = $item_row->point;
                $return['point_view'] = _number($item_row->point);
                $return['count'] = $item_row->count;
                $return['count_view'] = _number($item_row->count);
                $return['status'] = 1;
                // Update credit
                if ($config['vote_credit'] &&
                    $config['vote_credit_amount'] > 0 &&
                    $uid > 0
                    && Pi::service('module')->isActive('order')) {

                    // Set sub module
                    $subModule = !empty($subModule) ? $subModule : $module;

                    $where = array('uid' => $uid, 'item' => $item, 'table' => $table, 'module' => $module);
                    $select = Pi::model('point', $this->getModule())->select()->where($where);
                    $countPoint = Pi::model('point', $this->getModule())->selectWith($select)->count();

                    $where = array('module' => $subModule, 'status' => 1);
                    $select = Pi::model('score', $this->getModule())->select()->where($where);
                    $countScore = Pi::model('score', $this->getModule())->selectWith($select)->count();

                    // Check point and module
                    if ($countPoint == $countScore) {
                        switch ($subModule) {
                            case 'event':
                                $where = array('uid' => $uid, 'event' => $item);
                                $select = Pi::model('order', 'event')->select()->where($where);
                                $orderEvent = Pi::model('order', 'event')->selectWith($select)->count();
                                if ($orderEvent > 0) {
                                    Pi::api('credit', 'order')->addCredit(
                                        $uid,
                                        $config['vote_credit_amount'],
                                        'increase',
                                        'automatic',
                                        __('Add credit after voting'),
                                        __('Add credit after voting'),
                                        $subModule
                                    );
                                }
                                break;

                            default:
                                Pi::api('credit', 'order')->addCredit(
                                    $uid,
                                    $config['vote_credit_amount'],
                                    'increase',
                                    'automatic',
                                    __('Add credit after voting'),
                                    __('Add credit after voting'),
                                    $subModule
                                );
                                break;
                        }
                    }
                }
            } else {
                if (!$delay) {
                    $return['title'] = __('Error to voting');
                    $return['message'] = sprintf(__('You can vote after %s second'), $config['vote_delay']);
                } else {
                    $return['title'] = __('Error to voting');
                    $return['message'] = __('You already voted to this item');
                }
                $return['status'] = 0;
            }
        }
        return $return;
    }

    public function getVoteScore($module, $table, $item)
    {
        $list = array();
        $where = array('item' => $item, 'table' => $table, 'module' => $module);
        $select = Pi::model('point', $this->getModule())->select()->where($where);
        $rowset = Pi::model('point', $this->getModule())->selectWith($select);
        foreach ($rowset as $row) {
            $list[$row->score][$row->id] = $row->toArray();
        }
        return $list;
    }

    protected function checkDelay($uid, $ip, $time)
    {
        // Set where
        if ($uid > 0) {
            $where = array('ip' => $ip);
        } else {
            $where = array('uid' => $uid);
        }
        // Set order
        $order = array('time_create DESC', 'id DESC');
        $column = array('id', 'time_create');
        // Get info
        $select = Pi::model('point', $this->getModule())->select()->where($where)->columns($column)->order($order)->limit(1);
        $rowset = Pi::model('point', $this->getModule())->selectWith($select)->toArray();
        $time = $rowset[0]['time_create'] + $time;
        // check
        if (time() > $time) {
            return true;
        } else {
            return false;
        }
    }
}