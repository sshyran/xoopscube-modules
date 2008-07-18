<?php
require_once 'Sabai/Controller/Front.php';

class Xigg_Admin_Node_Comment extends Sabai_Controller_Front
{
    function Xigg_Admin_Node_Comment()
    {
        parent::Sabai_Controller_Front('List', 'Xigg_Admin_Node_Comment_', dirname(__FILE__) . '/Comment');
    }

    function _getRoutes(&$context)
    {
        $routes['node/:node_id/comment/list'] = array('controller' => 'List');
        $routes['node/:node_id/comment/submit'] = array('controller' => 'Submit');
        $routes['node/:node_id/comment/:comment_id/edit'] = array(
                                           'controller'   => 'Update',
                                           'requirements' => array(':comment_id' => '\d+'));
        return $routes;
    }
}