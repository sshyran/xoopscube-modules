<?php
require_once 'SabaiXOOPS/GroupPermissionController.php';

class xigg_xoops_admin_roles extends SabaiXOOPS_GroupPermissionController
{
    function xigg_xoops_admin_roles(&$module)
    {
        $options = array(
                     'successMsg' => _('Roles assigned to groups successfully'),
                     'errorMsg' => 'Failed to assign roles to groups');
        parent::SabaiXOOPS_GroupPermissionController($module, $options);
    }

    function _getRoles(&$context)
    {
        $role_list = array();
        $model =& $context->application->locator->getService('Model');
        $role_r =& $model->getRepository('Role');
        $roles =& $role_r->fetchAll();
        while ($role =& $roles->getNext()) {
            $role_list[$role->getId()] = $role->getLabel();
        }
        return $role_list;
    }
}