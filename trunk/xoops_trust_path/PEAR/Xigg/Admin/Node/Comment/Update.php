<?php
require_once 'Sabai/Controller/ModelEntityUpdate.php';

class Xigg_Admin_Node_Comment_Update extends Sabai_Controller_ModelEntityUpdate
{
    function Xigg_Admin_Node_Comment_Update()
    {
        parent::Sabai_Controller_ModelEntityUpdate('Comment', 'comment_id');
    }

    function &_getEntityForm(&$entity, &$context)
    {
        $form =& $entity->toForm();
        $form->removeElements(array('Node', 'content_syntax', 'body'));
        return $form;
    }

    function _onUpdateEntity(&$entity, &$context)
    {
        $context->response->setVars(array('breadcrumb_current' => _('Edit comment')));
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