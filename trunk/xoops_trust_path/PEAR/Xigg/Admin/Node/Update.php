<?php
require_once 'Sabai/Controller/ModelEntityUpdate.php';

class Xigg_Admin_Node_Update extends Sabai_Controller_ModelEntityUpdate
{
    function Xigg_Admin_Node_Update()
    {
        parent::Sabai_Controller_ModelEntityUpdate('Node', 'node_id');
    }

    function &_getEntityForm(&$entity, &$context)
    {
        $form =& $entity->toForm();
        $form->removeElements(array('content_syntax', 'teaser', 'body', 'Tags'));
        return $form;
    }

    function _onUpdateEntity(&$entity, &$context)
    {
        $context->response->setVars(array('breadcrumb_current' => _('Edit node')));
        return true;
    }

    function _onEntityUpdated(&$entity, &$context)
    {
        if ($tagging = $context->request->getAsStr('tagging', false)) {
            $entity->linkTagsByStr($tagging);
        }
        $this->_successURL = array('base' => '/node/' . $entity->getId());
    }

    function &_getModel(&$context)
    {
        $model =& $context->application->locator->getService('Model');
        return $model;
    }
}