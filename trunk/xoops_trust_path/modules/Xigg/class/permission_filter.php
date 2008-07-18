<?php
require_once 'Sabai/Controller/Filter.php';

class xigg_xoops_permission_filter extends Sabai_Controller_Filter
{
    function before(&$context)
    {
        // if (!$context->user->isAuthenticated()) {
        if (empty($GLOBALS['xoopsUser'])) {
            return;
        }
        $xoops_groups = $GLOBALS['xoopsUser']->getGroups();
        if (in_array(XOOPS_GROUP_ADMIN, $xoops_groups)) {
            $context->user->setAdmin(true);
            return;
        }
        $groupperm_h =& xoops_gethandler('groupperm');
        if ($groupperm_h->checkRight('module_admin', $GLOBALS['xoopsModule']->getVar('mid'), $xoops_groups)) {
            $context->user->setAdmin(true);
            return;
        }
        $perm_name = $GLOBALS['xoopsModule']->getVar('dirname') . '_role';
        if (!$role_ids = $groupperm_h->getItemIds($perm_name, $xoops_groups, $GLOBALS['xoopsModule']->getVar('mid'))) {
            return;
        }
        $model =& $context->application->locator->getService('Model');
        $role_r =& $model->getRepository('Role');
        $roles =& $role_r->fetchByCriteria(Sabai_Model_Criteria::createIn('role_id', $role_ids));
        $perms = $context->user->getPermissions();
        while ($role =& $roles->getNext()) {
            $perms = array_merge($perms, $role->getPermissions());
        }
        $context->user->setPermissions(array_unique($perms));
    }
}