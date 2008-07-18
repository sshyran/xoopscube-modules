<?php
require_once 'Sabai/Controller/ModelEntityUpdate.php';

class Xigg_Admin_Tag_Update extends Sabai_Controller_ModelEntityUpdate
{
    function Xigg_Admin_Tag_Update()
    {
        parent::Sabai_Controller_ModelEntityUpdate('Tag', 'tag_id');
    }

    function _onUpdateEntity(&$entity, &$context)
    {
        $context->response->setVar('breadcrumb_current', _('Edit tag'));
        return true;
    }

    function &_getEntityFrom(&$entity)
    {
        $form =& $entity->toForm();
        $form->removeElement('Nodes');
        return $form;
    }

    function &_getModel(&$context)
    {
        $model =& $context->application->locator->getService('Model');
        return $model;
    }

    function _onEntityUpdated(&$entity, &$context)
    {
        $this->_successURL = array('base' => '/tag/' . $entity->getId());
    }
}