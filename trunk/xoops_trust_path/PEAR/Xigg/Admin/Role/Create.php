<?php
require_once 'Sabai/Controller/ModelEntityCreate.php';

class Xigg_Admin_Role_Create extends Sabai_Controller_ModelEntityCreate
{
    function Xigg_Admin_Role_Create()
    {
        parent::Sabai_Controller_ModelEntityCreate('Role');
    }

    function &_getEntityForm(&$entity, &$context)
    {
        require dirname(__FILE__) . '/permissions.php';
        $form =& $entity->toForm(array('permissions' => $permissions));
        return $form;
    }

    function _onCreateEntity(&$entity, &$context)
    {
        $context->response->setVar('breadcrumb_current', _('Add role'));
        return true;
    }

    function &_getModel(&$context)
    {
        $model =& $context->application->locator->getService('Model');
        return $model;
    }

    function _onEntityCreated(&$entity, &$context)
    {
        $this->_successURL = array('base' => '/role/' . $entity->getId());
    }
}