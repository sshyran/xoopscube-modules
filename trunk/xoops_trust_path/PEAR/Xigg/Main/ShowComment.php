<?php
class Xigg_Main_ShowComment extends Sabai_Controller
{
    function _doExecute(&$context)
    {
        if (!$comment_id = $context->request->getAsInt('comment_id')) {
            $context->response->setError(_('Invalid comment'));
            return;
        }
        $model =& $context->application->locator->getService('Model');
        $comment_r =& $model->getRepository('Comment');
        if (!$comment =& $comment_r->fetchById($comment_id)) {
            $context->response->setError(_('Invalid comment'));
            return;
        }
        // cache the entity to reduce a query in the forwarded Shownode action
        $comment_r->cacheEntity($comment);
        $this->_parent->forward('/node/' . $comment->getVar('node_id'), $context);
    }
}