<?php
class Xigg_Main_DeleteCommentForm extends Sabai_Controller
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
        if (!$context->user->hasPermission('comment delete any')) {
            if (!$comment->isOwnedBy($context->user) || !$context->user->hasPermission('comment delete own')) {
                $context->response->setError(_('You are not allowed to delete this comment'), array('base' => '/comment/' . $comment->getId()));
                return;
            }
        }
        $comment_form =& $comment->toTokenForm('Comment_delete');
        $comment_form->removeElements(array('body', 'Node'));
        if ($context->request->isPost()) {
            if ($comment_form->validateValues($context->request->getAll())) {
                $comment->markRemoved();
                $return_url = array('base' => '/node/' . $comment->getVar('node_id'));
                if ($model->commit()) {
                    $context->response->setSuccess(sprintf(_('Comment #%d deleted successfully'), $comment_id), $return_url);
                    return;
                } else {
                	$error = 'Comment #%d could not be deleted.';
                	$error .= ' There was either an error while commit or the comment has one or more child comments.';
                	$context->response->setError(sprintf(_($error), $comment_id), $return_url);
                    return;
                }
            }
        }
        $comment_form->onView();
        $node =& $comment->get('Node');
        $context->response->setVars(array('comment_form' => &$comment_form,
                                 'comment'      => &$comment,
                                 'node'         => &$node));
    }
}