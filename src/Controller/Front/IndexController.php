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

namespace Module\Vote\Controller\Front;

use Pi;
use Pi\Mvc\Controller\ActionController;

class IndexController extends ActionController
{
    public function indexAction()
    {
        // Check post vote
        if ($this->request->isPost()) {
            $params = $this->params()->fromPost();
            return Pi::api('vote', 'vote')->doVote($params);
        } else {
            $this->jumpTo404();
        }
        // Set view
        $this->view()->setTemplate(false)->setLayout('layout-content');
    }
}