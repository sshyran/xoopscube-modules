<?php
require_once 'Sabai/Controller/Front.php';

class Xigg_Admin_Node_Vote extends Sabai_Controller_Front
{
    function Xigg_Admin_Node_Vote()
    {
        parent::Sabai_Controller_Front('List', 'Xigg_Admin_Node_Vote_', dirname(__FILE__) . '/Vote');
    }

    function _getRoutes(&$context)
    {
        $routes['node/:node_id/vote/list'] = array('controller' => 'List');
        $routes['node/:node_id/vote/submit'] = array('controller' => 'Submit');
        $routes['node/:node_id/vote/:vote_id/edit'] = array(
                                           'controller'   => 'Update',
                                           'requirements' => array(':vote_id' => '\d+'));
        return $routes;
    }
}