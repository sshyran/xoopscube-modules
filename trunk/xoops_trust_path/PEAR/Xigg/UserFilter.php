<?php
require_once 'Sabai/Controller/Filter.php';

class Xigg_UserFilter extends Sabai_Controller_Filter
{
    function before(&$context)
    {
        if (!$context->user->isAuthenticated() || $context->user->isInitialized()) {
            return;
        }
        $perms = $context->user->getPermissions();
        $model =& $context->application->locator->getService('Model');
        $member_r =& $model->getRepository('Member');
        $members =& $member_r->fetchByUser($context->user->getId());
        $members =& $members->with('Role');
        $members->rewind();
        while ($member =& $members->getNext()) {
            $role =& $member->get('Role');
            $perms = array_merge($perms, $role->getPermissions());
        }
        $context->user->setPermissions(array_unique($perms));
        $context->user->setInitialized();
    }
}