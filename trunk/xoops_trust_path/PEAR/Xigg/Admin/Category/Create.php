<?php
require_once 'Sabai/Controller/ModelEntityCreate.php';

class Xigg_Admin_Category_Create extends Sabai_Controller_ModelEntityCreate
{
    function Xigg_Admin_Category_Create()
    {
        $options = array('successURL' => array('base' => '/category'));
        parent::Sabai_Controller_ModelEntityCreate('Category', $options);
    }

    function _onCreateEntity(&$entity, &$context)
    {
        $context->response->setVar('breadcrumb_current', _('Add category'));
        return true;
    }

    function _onEntityCreated(&$entity, &$context)
    {
        $this->_successURL = array('base' => '/category/' . $entity->getId());
    }

    function &_getModel(&$context)
    {
        $model =& $context->application->locator->getService('Model');
        return $model;
    }
}