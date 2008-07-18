<?php
class Xigg_Main_EditTrackbackForm extends Sabai_Controller
{
    function _doExecute(&$context)
    {
        if (!$trackback_id = $context->request->getAsInt('trackback_id')) {
            $context->response->setError(_('Invalid trackback'));
            return;
        }
        $model =& $context->application->locator->getService('Model');
        $trackback_r =& $model->getRepository('Trackback');
        if (!$trackback =& $trackback_r->fetchById($trackback_id)) {
            $context->response->setError(_('Invalid trackback'));
            return;
        }
        if (!$context->user->hasPermission('trackback edit')) {
            $context->response->setError(_('You are not allowed to edit this trackback item'), array('base' => '/trackback/' . $trackback->getId()));
            return;
        }
        $trackback_form =& $trackback->toTokenForm('Trackback_edit');
        $trackback_form->removeElements(array('Node'));
        $plugin_mngr =& $context->application->locator->getService('PluginManager');
        if ($context->request->isPost()) {
            if ($trackback_form->validateValues($context->request->getAll())) {
                $plugin_mngr->dispatch('SubmitEditTrackbackForm', array(&$trackback_form));
                $trackback->applyForm($trackback_form);
                $plugin_mngr->dispatch('EditTrackback', array(&$trackback));
                if ($model->commit()) {
                    $context->response->setSuccess(_('Trackback updated successfully'), array('base' => '/node/' . $trackback->getVar('node_id'), 'params' => array('trackback_id' => $trackback_id), 'fragment' => 'trackback' . $trackback_id));
                    $plugin_mngr->dispatch('EditTrackbackSuccess', array(&$trackback));
                    return;
                }
            }
        }
        $trackback_form->onView();
        $node =& $trackback->get('Node');
        $plugin_mngr->dispatch('ShowEditTrackbackForm', array(&$trackback_form));
        $context->response->setVars(array('trackback_form' => &$trackback_form,
                                 'trackback'      => &$trackback,
                                 'node'           => &$node));
    }
}