<?php
require_once 'Sabai/Controller/Front.php';

class Xigg_Admin_User extends Sabai_Controller_Front
{
    function Xigg_Admin_User()
    {
        parent::Sabai_Controller_Front('List', 'Xigg_Admin_User_', dirname(__FILE__) . '/User');
    }

    function _getRoutes(&$context)
    {
        $routes['user/list'] = array('controller' => 'List');
        $routes['user/submit'] = array('controller' => 'Submit');
        return $routes;
    }
}