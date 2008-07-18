<?php
class Xigg_Main_DeleteTrackbackForm extends Sabai_Controller
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
        if (!$context->user->hasPermission('trackback delete')) {
            $context->response->setError(_('You are not allowed to delete this trackback item'), array('base' => '/trackback/' . $trackback->getId()));
            return;
        }
        $trackback_form =& $trackback->toTokenForm('Trackback_delete');
        $trackback_form->removeElements(array('Node'));
        if ($context->request->isPost()) {
            if ($trackback_form->validateValues($context->request->getAll())) {
                $trackback->markRemoved();
                $return_url = array('base' => '/node/' . $trackback->getVar('node_id') . '/trackbacktab');
                if ($model->commit()) {
                    $context->response->setSuccess(sprintf(_('Trackback #%d deleted successfully'), $trackback_id), $return_url);
                    return;
                }
            }
        }
        $trackback_form->onView();
        $node =& $trackback->get('Node');
        $context->response->setVars(array('trackback_form' => &$trackback_form,
                                 'trackback'      => &$trackback,
                                 'node'           => &$node));
    }
}