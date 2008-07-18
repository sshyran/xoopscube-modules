<?php
class Xigg_Main_EditCommentForm extends Sabai_Controller
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
        if (!$context->user->hasPermission('comment edit any')) {
            if (!$comment->get('allow_edit')) {
                $context->response->setError(_('This comment has been frozen by the administration'), array('base' => '/comment/' . $comment->getId()));
                return;
            }
            if (!$comment->isOwnedBy($context->user) || !$context->user->hasPermission('comment edit own')) {
                $context->response->setError(_('You are not allowed to edit this comment'), array('base' => '/comment/' . $comment->getId()));
                return;
            }
            if (time() > $comment->getTimeCreated() + $context->application->config->get('userCommentEditTime')) {
                $context->response->setError(_('Time allowed to edit your comment exceeded'), array('base' => '/node/' . $comment->getVar('node_id'), 'params' => array('comment_id' => $comment_id), 'comment' . $comment_id));
                return;
            }
        }
        $comment_form =& $comment->toTokenForm('Comment_edit');
        $comment_form->removeElements(array('Node'));
        if (!$context->user->hasPermission('comment allow edit')) {
            $comment_form->removeElements(array('allow_edit'));
        }
        if (!$context->user->hasPermission('comment edit html')) {
            $comment_form->removeElements(array('body_html'));
        }
        $plugin_mngr =& $context->application->locator->getService('PluginManager');
        if ($context->request->isPost()) {
            $comment_form->setValues($context->request->getAll());
            if ($context->request->getAsStr('change_syntax')) {
                // need to convert encoding since AJAX with Form.serialize() comes with UTF-8
                if (SABAI_CHARSET != 'UTF-8') {
                    foreach (array('title', 'body', 'body_html') as $comment_form_k) {
                        if ($comment_form->hasElement($comment_form_k)) {
                            $value = $comment_form->getValueFor($comment_form_k);
                            $value = mb_convert_encoding($value, SABAI_CHARSET, array(SABAI_CHARSET, 'UTF-8'));
                            $comment_form->setValueFor($comment_form_k, $value);
                        }
                    }
                }
            } elseif ($context->request->getAsStr('preview_form')) {
                $comment_form->validate();
                if ($comment_form->isValid()) {
                    $purifier =& $context->application->locator->getService('HTMLPurifier');
                    $comment->applyForm($comment_form);
                    if ($comment_form->hasElement('body_html')) {
                        if ($context->request->getAsBool('body_html_regenerate')) {
                            $comment->HTMLize($plugin_mngr);
                            $comment->purifyHTML($purifier);
                            // set purified HTML back to the form
                            $comment_form->setValueFor('body_html', $comment->get('body_html'));
                        } else {
                            $context->response->setVar('body_html_regenerate', false);
                        }
                    } else {
                        $comment->HTMLize($plugin_mngr);
                        $comment->purifyHTML($purifier);
                    }
                    $context->response->setVarRef('comment_preview', $comment);
                }
            } elseif ($context->request->getAsStr('submit_form')) {
                $comment_form->validate();
                if ($comment_form->isValid()) {
                    $plugin_mngr->dispatch('SubmitCommentForm', array(&$comment_form, /*$isReply*/ false));
                    $comment->applyForm($comment_form);
                    $plugin_mngr->dispatch('SubmitComment', array(&$comment, /*$isEdit*/ true));
                    if ($comment_form->hasElement('body_html')) {
                        if ($context->request->getAsBool('body_html_regenerate')) {
                            $comment->HTMLize($plugin_mngr);
                        }
                    } else {
                        $comment->HTMLize($plugin_mngr);
                    }
                    $purifier =& $context->application->locator->getService('HTMLPurifier');
                    $comment->purifyHTML($purifier);
                    if ($model->commit()) {
                        $context->response->setSuccess(_('Comment updated successfully'), array('base' => '/node/' . $comment->getVar('node_id'), 'params' => array('comment_id' => $comment_id), 'fragment' => 'comment' . $comment_id));

                        $plugin_mngr->dispatch('SubmitCommentSuccess', array(&$comment, /*$isEdit*/ true));
                        return;
                    }
                }
            }
        }
        $comment_form->onView();
        $node =& $comment->get('Node');
        $plugin_mngr->dispatch('ShowCommentForm', array(&$comment_form, /*$isEdit*/ true));
        $context->response->setVars(array('comment_form' => &$comment_form,
                                 'comment'      => &$comment,
                                 'node'         => &$node));
    }
}