<?php
class Xigg_Main_ShowCommentReplies extends Sabai_Controller
{
    function _doExecute(&$context)
    {
        if (!$comment_id = $context->request->getAsInt('comment_id', false)) {
            $context->response->setError(_('Invalid comment'));
            return;
        }
        $model =& $context->application->locator->getService('Model');
        $comment_r =& $model->getRepository('Comment');
        if (!$comment =& $comment_r->fetchById($comment_id)) {
            $context->response->setError(_('Comment does not exist'));
            return;
        }
        $node =& $comment->get('Node');
        if (!$node->isReadable($context->user)) {
            $context->response->setError(_('Invalid node'));
            return;
        }
        $descendants =& $comment->descendantsAsTree();
        $comment_form_show = false;
        if ($node->get('allow_comments')) {
            if ($context->user->isAuthenticated() || $context->application->config->get('guestCommentsAllowed')) {
                $comment_form_show = true;
            }
        }
        $context->response->setVars(array('node'              => &$node,
                                 'comment'           => &$comment,
                                 'comment_replies'   => &$descendants,
                                 'comment_form_show' => $comment_form_show));
    }
}