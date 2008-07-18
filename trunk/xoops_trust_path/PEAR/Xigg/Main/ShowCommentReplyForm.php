<?php
class Xigg_Main_ShowCommentReplyForm extends Sabai_Controller
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
        if (!$node->get('allow_comments') || !$node->isReadable($context->user)) {
            $context->response->setError(_('Comment not allowed for this node'), array('base' => '/node/' . $node->getId(), 'params' => array('comment_id' => $comment->getId()), 'fragment' => 'comment' . $comment->getId()));
            return;
        }
        $vars = array('comment_id' => $comment_id);
        $reply =& $node->createComment();
        $form =& $reply->toTokenForm('Comment_reply_' . $comment_id);
        $form->removeElements(array('Node', 'content_syntax', 'body_html', 'allow_edit'));
        $form->setValueFor('body', sprintf('<blockquote cite="%s" title="%s">%s</blockquote>', $context->request->createUri(array('base' => '/comment/' . $comment_id)), h($comment->getLabel()), "\n" . $comment->get('body') . "\n"));
        //$form->setValueFor('body', "\n\n" . strtr("\n" . $comment->get('body'), array("\n>" => "\n>>", "\n" => "\n> ")));
        $comment_title = trim($comment->getLabel());
        $reply_title = !preg_match('/^Re: /i', $comment_title) ? 'Re: ' . $comment_title : $comment_title;
        $form->setValueFor('title', $reply_title);
        $form->onView();
        $plugin_mngr =& $context->application->locator->getService('PluginManager');
        $plugin_mngr->dispatch('ShowCommentForm', array(&$form, /*$isReply*/ true));
        $vars['comment_form'] =& $form;
        $vars['node'] =& $node;
        $context->response->setVars($vars);
    }
}