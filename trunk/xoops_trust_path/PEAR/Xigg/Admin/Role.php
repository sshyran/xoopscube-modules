<?php
require_once 'Sabai/Controller/Front.php';

class Xigg_Admin_Role extends Sabai_Controller_Front
{
    function Xigg_Admin_Role()
    {
        parent::Sabai_Controller_Front('List', 'Xigg_Admin_Role_', dirname(__FILE__) . '/Role');
        $this->addControllerFilter(array('Update', 'Delete', 'Details', 'Member'), '_isValidRoleRequested');
        $this->addControllerFilter(array('Update', 'Delete'), '_isRoleEditable');
    }

    function _getRoutes(&$context)
    {
        $routes = array();
        $routes['role/list'] = array('controller' => 'List');
        $routes['role/add'] = array('controller' => 'Create');
        $routes['role/:role_id/edit'] = array('controller' => 'Update', 'requirements' => array('role_:id' => '\d+'));
        $routes['role/:role_id/delete'] = array('controller' => 'Delete', 'requirements' => array('role_:id' => '\d+'));
        $routes['role/:role_id/member'] = array('controller' => 'Member', 'requirements' => array('role_:id' => '\d+'));
        $routes['role/:role_id'] = array('controller' => 'Details', 'requirements' => array('role_:id' => '\d+'));
        return $routes;
    }

    function _isValidRoleRequestedBeforeFilter(&$context)
    {
        $this->_parent->isValidEntityRequestedBeforeFilter('Role', $context);
    }

    function _isRoleEditableBeforeFilter(&$context)
    {
        $model =& $context->application->locator->getService('Model');
        $role_r =& $model->getRepository('Role');
        $role =& $role_r->fetchById($context->request->getAsInt('role_id'));
        if ($role->get('system')) {
            $context->response->setError(_('System defined roles may not be edited nor deleted'), array('base' => '/role'));
            $context->response->send($context->request);
            exit;
        }
    }
}