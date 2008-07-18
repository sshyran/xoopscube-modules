<?php
require_once 'Sabai/Controller/ModelEntityDelete.php';

class Xigg_Admin_Node_Delete extends Sabai_Controller_ModelEntityDelete
{
    function Xigg_Admin_Node_Delete()
    {
        $url = array('base' => '/node');
        $options = array('successURL' => $url, 'errorURL' => $url);
        parent::Sabai_Controller_ModelEntityDelete('Node', 'node_id', $options);
    }

    function _onDeleteEntity(&$entity, &$context)
    {
        $context->response->setVars(array('breadcrumb_current' => _('Delete node')));
        return true;
    }

    function &_getModel(&$context)
    {
        $model =& $context->application->locator->getService('Model');
        return $model;
    }
}