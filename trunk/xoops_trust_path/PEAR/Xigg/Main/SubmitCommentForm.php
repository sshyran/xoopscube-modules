<?php
class Xigg_Main_SubmitCommentForm extends Sabai_Controller
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
        $plugin_mngr =& $context->application->locator->getService('PluginManager');
        $vars = array();
        $comment =& $node->createComment();
        $comment_form =& $comment->toTokenForm('Comment_submit');
        $comment_form->removeElements(array('Node', 'body_html', 'allow_edit'));
        $comment_form->setValueFor('title', 'Re: ' . trim($node->getLabel()));
        if ($context->request->isPost()) {
            $comment_form->setValues($context->request->getAll());
            if ($context->request->getAsStr('change_syntax')) {
                // need to convert encoding since AJAX with Form.serialize() comes with UTF-8
                if (SABAI_CHARSET != 'UTF-8') {
                    foreach (array('title', 'body') as $comment_k) {
                        $comment_form->setValueFor($comment_k,
                                                   mb_convert_encoding($comment_form->getValueFor($comment_k),
                                                   SABAI_CHARSET,
                                                   array(SABAI_CHARSET, 'UTF-8')));
                    }
                }
            } elseif ($context->request->getAsStr('preview_form')) {
                $comment_form->validate();
                if ($comment_form->isValid()) {
                    $comment->applyForm($comment_form);
                    $comment->HTMLize($plugin_mngr);
                    $comment->purifyHTML($context->application->locator->getService('HTMLPurifier'));
                    $vars['comment_preview'] =& $comment;
                }
            } elseif ($context->request->getAsStr('submit_form')) {
                $comment_form->validate();
                if ($comment_form->isValid()) {
                    $plugin_mngr->dispatch('SubmitCommentForm', array(&$comment_form, /*$isReply*/ false));
                    $comment->applyForm($comment_form);
                    $comment->assignUser($context->user);
                    $comment->markNew();
                    $plugin_mngr->dispatch('SubmitComment', array(&$comment, /*$isReply*/ false));
                    $comment->HTMLize($plugin_mngr);
                    $comment->purifyHTML($context->application->locator->getService('HTMLPurifier'));
                    if ($comment->commit()) {
                        $context->response->setSuccess(_('Comment posted successfully'), array('base' => '/node/' . $node->getId(), 'params' => array('comment_id' => $comment->getId()), 'fragment' => 'comment' . $comment->getId()));
                        $plugin_mngr->dispatch('SubmitCommentSuccess', array(&$comment));
                        return;
                    }
                }
            }
        }
        $comment_form->onView();
        $plugin_mngr->dispatch('ShowCommentForm', array(&$comment_form, /*$isReply*/ false));
        $vars['comment_form'] =& $comment_form;
        $vars['node'] =& $node;
        $context->response->setVars($vars);
    }
}