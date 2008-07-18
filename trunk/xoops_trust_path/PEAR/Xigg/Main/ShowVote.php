<?php
class Xigg_Main_ShowVote extends Sabai_Controller
{
    function _doExecute(&$context)
    {
        if (!$vote_id = $context->request->getAsInt('vote_id')) {
            $context->response->setError(_('Invalid vote'));
            return;
        }
        $model =& $context->application->locator->getService('Model');
        $vote_r =& $model->getRepository('Vote');
        if (!$vote =& $vote_r->fetchById($vote_id)) {
            $context->response->setError(_('Invalid vote'));
            return;
        }
        // cache the entity to reduce a query in the forwarded Shownode action
        $vote_r->cacheEntity($vote);
        $this->_parent->forward('/node/' . $vote->getVar('node_id'), $context);
    }
}