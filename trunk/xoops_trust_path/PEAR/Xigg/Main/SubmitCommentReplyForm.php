<?php
class Xigg_Main_SubmitCommentReplyForm extends Sabai_Controller
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
        $plugin_mngr =& $context->application->locator->getService('PluginManager');
        $vars = array('comment_id' => $comment_id, 'comment' => &$comment);
        if ($node->get('allow_comments')) {
            $reply =& $node->createComment();
            $reply_form =& $reply->toTokenForm('Comment_reply_' . $comment_id);
            $reply_form->removeElements(array('Node', 'body_html', 'allow_edit'));
            $comment_title = trim($comment->getLabel());
            $reply_title = !preg_match('/^Re:/i', $comment_title) ? 'Re: ' . $comment_title : $comment_title;
            $reply_form->setValueFor('title', $reply_title);
            $reply_form->setValueFor('body', sprintf('<blockquote cite="%s" title="%s">%s</blockquote>', $context->request->createUri(array('base' => '/comment/' . $comment_id)), h($comment_title), "\n" . $comment->get('body') . "\n"));
            //$reply_form->setValueFor('body', "\n\n" . strtr("\n" . $comment->get('body'), array("\n>" => "\n>>", "\n" => "\n> ")));
            if ($context->request->isPost()) {
                $reply_form->setValues($context->request->getAll());
                if ($context->request->getAsStr('change_syntax')) {
                    // need to convert encoding since AJAX with Form.serialize() comes with UTF-8
                    if (SABAI_CHARSET != 'UTF-8') {
                        foreach (array('title', 'body') as $reply_k) {
                            $reply_form->setValueFor($reply_k,
                                                     mb_convert_encoding($reply_form->getValueFor($reply_k),
                                                     SABAI_CHARSET,
                                                     array(SABAI_CHARSET, 'UTF-8')));
                        }
                    }
                } elseif ($context->request->getAsStr('preview_form')) {
                    $reply_form->validate();
                    if ($reply_form->isValid()) {
                        $reply->applyForm($reply_form);
                        $reply->HTMLize($plugin_mngr);
                        $reply->purifyHTML($context->application->locator->getService('HTMLPurifier'));
                        $vars['comment_preview'] =& $reply;
                    }
                } elseif ($context->request->getAsStr('submit_form')) {
                    $reply_form->validate();
                    if ($reply_form->isValid()) {
                        $plugin_mngr->dispatch('SubmitCommentForm', array(&$reply_form, /*$isReply*/ true));
                        $reply->applyForm($reply_form);
                        $reply->setVar('parent', $comment_id);
                        $reply->assignUser($context->user);
                        $reply->markNew();
                        $plugin_mngr->dispatch('SubmitComment', array(&$reply, /*$isReply*/ true));
                        $reply->HTMLize($plugin_mngr);
                        $reply->purifyHTML($context->application->locator->getService('HTMLPurifier'));
                        if ($reply->commit()) {
                            $context->response->setSuccess(sprintf(_('Reply to comment #%d posted successfully'), $comment_id), array('base' => '/node/' . $node->getId(), 'params' => array('comment_id' => $reply->getId()), 'fragment' => 'comment' . $reply->getId()));
                            $plugin_mngr->dispatch('SubmitCommentSuccess', array(&$comment));
                            return;
                        }
                    }
                }
            }
            $reply_form->onView();
            $vars['comment_form'] =& $reply_form;
            $plugin_mngr->dispatch('ShowCommentForm', array(&$reply_form, /*$isReply*/ true));
        }
        $vars['node'] =& $node;
        $context->response->setVars($vars);
    }
}