<?php
class Xigg_Main_ShowTrackback extends Sabai_Controller
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
        // cache the entity so as to reduce a query in the Shownode action
        $trackback_r->cacheEntity($trackback);
        $this->_parent->forward('/node/' . $trackback->getVar('node_id'), $context);
    }
}