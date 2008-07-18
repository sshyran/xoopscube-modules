<?php
require_once 'Sabai/Controller/ModelEntityUpdate.php';

class Xigg_Admin_Node_Trackback_Update extends Sabai_Controller_ModelEntityUpdate
{
    function Xigg_Admin_Node_Trackback_Update()
    {
        parent::Sabai_Controller_ModelEntityUpdate('Trackback', 'trackback_id');
    }

    function &_getEntityForm(&$entity, &$context)
    {
        $form =& $entity->toForm();
        $form->removeElement('Node');
        return $form;
    }

    function _onUpdateEntity(&$entity, &$context)
    {
        $context->response->setVars(array('breadcrumb_current' => _('Edit trackback')));
        return true;
    }

    function _onEntityUpdated(&$entity, &$context)
    {
        $this->_successURL = array('base' => '/node/' . $context->request->getAsInt('node_id'));
    }

    function &_getModel(&$context)
    {
        $model =& $context->application->locator->getService('Model');
        return $model;
    }
}