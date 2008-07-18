<?php
require_once 'Sabai/Controller/ModelEntityDelete.php';

class Xigg_Admin_Tag_Delete extends Sabai_Controller_ModelEntityDelete
{
    function Xigg_Admin_Tag_Delete()
    {
        $url = array('base' => '/tag');
        $options = array('successURL' => $url, 'errorURL' => $url);
        parent::Sabai_Controller_ModelEntityDelete('Tag', 'tag_id', $options);
    }

    function _onDeleteEntity(&$entity, &$context)
    {
        $context->response->setVar('breadcrumb_current', _('Delete tag'));
        return true;
    }

    function &_getEntityForm(&$entity, &$context)
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
}