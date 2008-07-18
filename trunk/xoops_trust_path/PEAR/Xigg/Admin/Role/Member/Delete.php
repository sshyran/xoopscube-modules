<?php
require_once 'Sabai/Controller/ModelEntityDelete.php';

class Xigg_Admin_Role_Member_Delete extends Sabai_Controller_ModelEntityDelete
{
    function Xigg_Admin_Role_Member_Delete()
    {
        $url = array('base' => '/role');
        $options = array('successURL' => $url, 'errorURL' => $url);
        parent::Sabai_Controller_ModelEntityDelete('Member', 'member_id', $options);
    }

    function _onDeleteEntity(&$entity, &$context)
    {
        // prevent removing yourself from the admin role
        if ($entity->getUserId() == $context->user->getId()) {
            $role =& $entity->get('Role');
            if ($role->get('system')) {
                $context->response->setError(_('You may not remove yourself from the system defined role'), array('base' => '/role/' . $role->getId()));
                return false;
            }
        }
        $context->response->setVar('breadcrumb_current', _('Remove member'));
        return true;
    }

    function _onEntityDeleted(&$entity, &$context)
    {
        $this->_successURL = array('base' => '/role/' . $entity->getVar('role_id'));
    }

    function &_getModel(&$context)
    {
        $model =& $context->application->locator->getService('Model');
        return $model;
    }
}