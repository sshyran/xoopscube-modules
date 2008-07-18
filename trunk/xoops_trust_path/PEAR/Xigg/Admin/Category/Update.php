<?php
require_once 'Sabai/Controller/ModelEntityUpdate.php';

class Xigg_Admin_Category_Update extends Sabai_Controller_ModelEntityUpdate
{
    function Xigg_Admin_Category_Update()
    {
        parent::Sabai_Controller_ModelEntityUpdate('Category', 'category_id');
    }

    function _onUpdateEntity(&$entity, &$context)
    {
        $context->response->setVar('breadcrumb_current', _('Edit category'));
        return true;
    }

    function _onEntityUpdated(&$entity, &$context)
    {
        $this->_successURL = array('base' => '/category/' . $entity->getId());
    }

    function &_getModel(&$context)
    {
        $model =& $context->application->locator->getService('Model');
        return $model;
    }
}