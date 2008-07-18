<?php
require_once 'Sabai/Controller/Front.php';

class Xigg_Admin_Node extends Sabai_Controller_Front
{
    function Xigg_Admin_Node()
    {
        parent::Sabai_Controller_Front('List', 'Xigg_Admin_Node_', dirname(__FILE__) . '/Node');
        $this->addControllerFilter(array('Comment', 'Trackback', 'Vote', 'Update', 'Delete', 'Details'), '_isValidNodeRequested');
    }

    function _getRoutes(&$context)
    {
        $routes['node/list'] = array('controller' => 'List');
        $routes['node/submit'] = array('controller' => 'Submit');
        $routes['node/:node_id/comment'] = array(
                                              'controller'   => 'Comment',
                                              'requirements' => array(':node_id' => '\d+'));
        $routes['node/:node_id/trackback'] = array(
                                                'controller'   => 'Trackback',
                                                'requirements' => array(':node_id' => '\d+'));
        $routes['node/:node_id/vote'] = array(
                                           'controller'   => 'Vote',
                                           'requirements' => array(':node_id' => '\d+'));
        $routes['node/:node_id/edit'] = array(
                                           'controller'   => 'Update',
                                           'requirements' => array(':node_id' => '\d+'));
        $routes['node/:node_id/delete'] = array(
                                           'controller'   => 'Delete',
                                           'requirements' => array(':node_id' => '\d+'));
        $routes['node/:node_id'] = array(
                                           'controller'   => 'Details',
                                           'requirements' => array(':node_id' => '\d+'));
        return $routes;
    }

    function _isValidNodeRequestedBeforeFilter(&$context)
    {
        $this->_parent->isValidEntityRequestedBeforeFilter('Node', $context);
    }
}