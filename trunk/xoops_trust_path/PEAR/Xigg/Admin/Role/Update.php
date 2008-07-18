<?php
require_once 'Sabai/Controller/ModelEntityUpdate.php';

class Xigg_Admin_Role_Update extends Sabai_Controller_ModelEntityUpdate
{
    function Xigg_Admin_Role_Update()
    {
        parent::Sabai_Controller_ModelEntityUpdate('Role', 'role_id');
    }

    function &_getEntityForm(&$entity, &$context)
    {
        require dirname(__FILE__) . '/permissions.php';
        $form =& $entity->toForm(array('permissions' => $permissions));
        return $form;
    }

    function _onUpdateEntity(&$entity, &$context)
    {
        $context->response->setVar('breadcrumb_current', _('Edit role'));
        return true;
    }

    function &_getModel(&$context)
    {
        $model =& $context->application->locator->getService('Model');
        return $model;
    }

    function _onEntityUpdated(&$entity, &$context)
    {
        $this->_successURL = array('base' => '/role/' . $entity->getId());
    }
}