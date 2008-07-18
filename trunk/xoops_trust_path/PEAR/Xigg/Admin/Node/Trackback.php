<?php
require_once 'Sabai/Controller/Front.php';

class Xigg_Admin_Node_Trackback extends Sabai_Controller_Front
{
    function Xigg_Admin_Node_Trackback()
    {
        parent::Sabai_Controller_Front('List', 'Xigg_Admin_Node_Trackback_', dirname(__FILE__) . '/Trackback');
    }

    function _getRoutes(&$context)
    {
        $routes['node/:node_id/trackback/list'] = array('controller' => 'List');
        $routes['node/:node_id/trackback/submit'] = array('controller' => 'Submit');
        $routes['node/:node_id/trackback/:trackback_id/edit'] = array(
                                           'controller'   => 'Update',
                                           'requirements' => array(':trackback_id' => '\d+'));
        return $routes;
    }
}