<?php
require_once 'Sabai/Controller/ModelEntityDelete.php';

class Xigg_Admin_Role_Delete extends Sabai_Controller_ModelEntityDelete
{
    function Xigg_Admin_Role_Delete()
    {
        $url = array('base' => '/role');
        $options = array('successURL' => $url, 'errorURL' => $url);
        parent::Sabai_Controller_ModelEntityDelete('Role', 'role_id', $options);
    }

    function &_getEntityForm(&$entity, &$context)
    {
        require dirname(__FILE__) . '/permissions.php';
        $form =& $entity->toForm(array('permissions' => $permissions));
        return $form;
    }

    function _onDeleteEntity(&$entity, &$context)
    {
        $context->response->setVar('breadcrumb_current', _('Delete role'));
        return true;
    }

    function &_getModel(&$context)
    {
        $model =& $context->application->locator->getService('Model');
        return $model;
    }
}