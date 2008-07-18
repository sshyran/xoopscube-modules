<?php
require_once 'Sabai/Controller/ModelEntityCreate.php';

class Xigg_Admin_Tag_Create extends Sabai_Controller_ModelEntityCreate
{
    function Xigg_Admin_Tag_Create()
    {
         parent::Sabai_Controller_ModelEntityCreate('Tag');
    }

    function _onCreateEntity(&$entity, &$context)
    {
        $context->response->setVar('breadcrumb_current', _('Add tag'));
        return true;
    }

    function &_getModel(&$context)
    {
        $model =& $context->application->locator->getService('Model');
        return $model;
    }

    function _onEntityCreated(&$entity, &$context)
    {
        $this->_successURL = array('base' => '/tag/' . $entity->getId());
    }
}