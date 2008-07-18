<?php
require_once 'Sabai/Controller/Front.php';

class Xigg_Admin_Role_Member extends Sabai_Controller_Front
{
    function Xigg_Admin_Role_Member()
    {
        parent::Sabai_Controller_Front('List', 'Xigg_Admin_Role_Member_', dirname(__FILE__) . '/Member');
        $this->addControllerFilter(array('Delete'), 'isValidMemberRequested');
    }

    function _getRoutes(&$context)
    {
        $routes['role/:role_id/member/list'] = array('controller' => 'List');
        $routes['role/:role_id/member/submit'] = array('controller' => 'Submit');
        $routes['role/:role_id/member/add'] = array('controller' => 'Create');
        $routes['role/:role_id/member/:member_id/remove'] = array('controller' => 'Delete', 'requirements' => array('member_:id' => '\d+'));
        return $routes;
    }

    function isValidMemberRequestedBeforeFilter(&$context)
    {
        $admin_controller =& $this->_parent->getParent();
        $admin_controller->isValidEntityRequestedBeforeFilter('Member', $context);
    }
}