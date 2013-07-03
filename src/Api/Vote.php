<?php
/**
 * Vote module Bar API
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

namespace Module\Vote\Api;

use Pi;
use Pi\Application\AbstractApi;
use Pi\Db\RowGateway\RowGateway;

/*
 * Pi::service('api')->vote(array('Vote', 'loadVote'), $module, $item);
 * Pi::service('api')->vote(array('Vote', 'doVote'), $params);
 */

class Vote extends AbstractApi
{
    public function load($module, $item)
    {
        // Set point and count
        $vote = '';
        $where = array('item' => $item, 'module' => $module);
        $columns = array('count', 'point');
        $select = Pi::model('case', $this->getModule())->select()->columns($columns)->where($where)->limit(1);
        $row = Pi::model('case', $this->getModule())->selectWith($select)->toArray();
        if(!empty($row)) {
            $vote = $row[0];
        }
        return $vote;
    }
    
    public function doVote($params)
    {
		 	// Chech vote number
		   if (!in_array($params['vote'], array('-1', '1', '2', '3', '4', '5', '6', '7', '8', '9', '10'))) {
		       $return['message'] = __('Your vote number is not true');
		       $return['status'] = 0;
		   } else {
		       $return = $this->vote($params['to'], $params['item'], $params['vote'], $params['table']);
		   }
		   return $return;
    }
    
    protected function vote($module, $item, $vote, $table = null)
    {
        // Get config
        $config = Pi::service('registry')->config->read('vote', 'vote');
        // Get user
        $uid = Pi::registry('user')->id;
        if ($uid == 0) {
            $return['message'] = __('Please login for vote');
            $return['status'] = 0;
        } else {
            // user voted to this item ?
            $select = Pi::model('point', $this->getModule())->select()->where(array('uid' => $uid, 'item' => $item, 'module' => $module));
            $count = Pi::model('point', $this->getModule())->selectWith($select)->count();
            // Check delay
            $delay = true;
            if($config['vote_delay']) {
		          $delay = $this->checkDelay($uid, $config['vote_delay']);	
            }
            if (!$count && $delay) {
                // Get case record
                $select = Pi::model('case', $this->getModule())->select()->where(array('item' => $item, 'module' => $module))->limit(1);
                $rowset = Pi::model('case', $this->getModule())->selectWith($select);
                foreach ($rowset as $row) {
                    $case = $row->toArray();
                }
                // set and save case record
                if (!empty($case)) {
                    $case_row = Pi::model('case', $this->getModule())->find($case['id']);
                    $case_row->point = $case_row->point + $vote;
                    $case_row->count = $case_row->count + 1;
                    $case_row->save();
                } else {
                    $case_row = Pi::model('case', $this->getModule())->createRow();
                    $case_row->point = $vote;
                    $case_row->count = 1;
                    $case_row->module = $module;
                    $case_row->item = $item;
                    $case_row->save();
                }
                // Save info in point table
                $point_row = Pi::model('point', $this->getModule())->createRow();
                $point_row->uid = $uid;
                $point_row->item = $item;
                $point_row->module = $module;
                $point_row->point = $vote;
                $point_row->case = $case_row->id;
                $point_row->hostname = getenv('REMOTE_ADDR');
                $point_row->create = time();
                $point_row->save();
                // Return
                $return['point'] = $case_row->point;
                $return['count'] = $case_row->count;
                $return['status'] = 1;
                // Save vote to main module table
	             if (isset($table)) {
			           $this->save($module, $table, $item, $case_row->point, $case_row->count);
			       }
            } else {
            	 if(!$delay) {
                	 $return['message'] = sprintf(__('You can vote after %s second'), $config['vote_delay']);
                } else {
                	 $return['message'] = __('You already voted to this item');		
                }	 
            	 $return['status'] = 0;
            }	
        }
        return $return;
    }
    
    /*
	  * For save vote info in your module tables too,
	  * you must add point and count columns in your module table
	  */
    protected function save($module, $table, $item, $point, $count)
    {
        Pi::model($table, $module)->update(array('point' => $point, 'count' => $count), array('id' => $item));
    }
    
    protected function checkDelay($uid, $time) 
    {
        // Set where
        $where = array('uid' => $uid);
        // Set order
        $order = array('create DESC', 'id DESC');
        $column = array('id', 'create');
        // Get info
        $select = Pi::model('point', $this->getModule())->select()->where($where)->columns($column)->order($order)->limit(1);
        $rowset = Pi::model('point', $this->getModule())->selectWith($select)->toArray();
        $time = $rowset[0]['create'] + $time;
        // check
        if(time() > $time) {
            return true;
        } else {
            return false;
        }		
    }
}	