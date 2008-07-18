<?php
require_once 'Sabai/Controller/ModelEntityDelete.php';

class Xigg_Admin_Category_Delete extends Sabai_Controller_ModelEntityDelete
{
    function Xigg_Admin_Category_Delete()
    {
        $url = array('base' => '/category');
        $options = array('successURL' => $url, 'errorURL' => $url);
        parent::Sabai_Controller_ModelEntityDelete('Category', 'category_id', $options);
    }

    function _onDeleteEntity(&$entity, &$context)
    {
        if ($entity->descendantsCount() > 0) {
            $context->response->setError('Category with child categories may not be deleted', array('base' => '/category'));
            return false;
        }
        $context->response->setVar('breadcrumb_current', _('Delete category'));
        return true;
    }

    function &_getModel(&$context)
    {
        $model =& $context->application->locator->getService('Model');
        return $model;
    }
}