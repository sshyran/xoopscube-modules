<?php
class Xigg_Main_ShowCommentForm extends Sabai_Controller
{
    function _doExecute(&$context)
    {
        if ((!$node =& $this->_parent->getNodeById($context, 'node_id')) || !$node->isReadable($context->user)) {
            $context->response->setError(_('Invalid node'));
            return;
        }
        if (!$node->get('allow_comments') || !$node->isReadable($context->user)) {
            $context->response->setError(_('Comment not allowed for this node'), array('base' => '/node/' . $node->getId()));
            return;
        }
        $comment =& $node->createComment();
        $comment_form =& $comment->toTokenForm('Comment_submit');
        $comment_form->removeElements(array('Node', 'content_syntax', 'body_html', 'allow_edit'));
        $node_title = trim($node->getLabel());
        $comment_title = !preg_match('/^Re:/i', $node_title) ? 'Re: ' . $node_title : $node_title;
        $comment_form->setValueFor('title', $comment_title);
        $comment_form->onView();
        $plugin_mngr =& $context->application->locator->getService('PluginManager');
        $plugin_mngr->dispatch('ShowCommentForm', array(&$comment_form, /*$isReply*/ false));
        $context->response->setVars(array('comment_form' => &$comment_form, 'node' => &$node));
    }
}